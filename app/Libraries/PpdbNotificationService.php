<?php

namespace App\Libraries;

use Config\Services;
use App\Models\PpdbConfigModel;

class PpdbNotificationService
{
    private array $config;

    public function __construct()
    {
        // Ambil semua konfigurasi dari database saat service diinisialisasi
        $this->config = (new PpdbConfigModel())->getConfig();
    }

    public function sendStatusNotification(array $item, string $status): array
    {
        $result = [
            'email_sent' => false,
            'wa_sent'    => false,
            'errors'     => [],
        ];

        if (! in_array($status, ['Diterima', 'Ditolak'], true)) {
            return $result;
        }

        $emailResult = $this->sendEmail($item, $status);
        $result['email_sent'] = $emailResult['sent'];
        if (! $emailResult['sent']) {
            $result['errors'][] = $emailResult['error'];
        }

        // WhatsApp dihilangkan dari sini karena akan dikirim manual via Button
        return $result;
    }

    /**
     * Menghasilkan link WhatsApp manual (api.whatsapp.com)
     */
    public function getWhatsAppLink(array $item): string
    {
        $phone   = $this->normalizePhone((string) ($item['telepon'] ?? ''));
        $message = $this->buildWhatsAppAnnouncement($item, $item['status'] ?? 'Menunggu');
        
        return "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);
    }

    private function getSiteName(): string
    {
        if (!empty($this->config['ppdb_email_from_name'])) {
            return $this->config['ppdb_email_from_name'];
        }
        
        return env('email.fromName') ?: (config('Email')->fromName ?? 'SD Negeri 56 Prabumulih');
    }

    private function sendEmail(array $item, string $status): array
    {
        $email = Services::email();
        $email->clear(true);
        
        // Pastikan format email adalah HTML karena menggunakan View
        $email->setMailType('html');

        // Paksa karakter newline untuk kompatibilitas SMTP Gmail
        $email->setNewline("\r\n");
        $email->setCRLF("\r\n");

        // Gunakan !empty untuk menghindari string kosong dari DB yang menimpa .env
        $fromEmail = !empty($this->config['ppdb_email_from']) 
            ? $this->config['ppdb_email_from'] 
            : (env('email.fromEmail') ?: config('Email')->fromEmail);

        $fromName = $this->getSiteName();

        $email->setFrom($fromEmail, $fromName);
        $email->setTo($item['email']);

        $statusLabel = ($status === 'Diterima') ? 'DITERIMA' : 'TIDAK DITERIMA';
        
        $subject = $status === 'Diterima'
            ? 'Pengumuman Hasil PPDB: DITERIMA'
            : 'Pengumuman Hasil PPDB: TIDAK DITERIMA';

        $email->setSubject($subject . ' - ' . $fromName);

        $message = view('emails/ppdb_status', [
            'nama'      => (string) ($item['nama'] ?? ''),
            'status'    => $status,
            'id_ppdb'   => (int) ($item['id_ppdb'] ?? 0),
            'site_name' => $fromName,
        ]);

        $email->setMessage($message);

        if ($email->send()) {
            return ['sent' => true, 'error' => ''];
        }

        // Catat error teknis di log agar admin bisa memeriksa detailnya
        $debug = $email->printDebugger(['headers', 'subject', 'body']);
        log_message('error', "[PPDB EMAIL ERROR] SMTP Debug: " . $debug);

        // Debugging Konfigurasi
        $conf = config('Email');
        log_message('debug', "SMTP Config Test -> User: " . $conf->SMTPUser);
        log_message('debug', "SMTP Config Test -> Pass Status: " . (empty($conf->SMTPPass) ? 'KOSONG' : 'TERISI'));
        log_message('debug', "SMTP Config Test -> Crypto: " . $conf->SMTPCrypto);
        log_message('debug', "SMTP Config Test -> Port: " . $conf->SMTPPort);

        return [
            'sent'  => false,
            'error' => 'Gagal kirim email. Pastikan App Password & konfigurasi .env sudah benar.',
        ];
    }

    private function buildWhatsAppAnnouncement(array $item, string $status): string
    {
        $nama = (string) ($item['nama'] ?? '');
        $id   = (int) ($item['id_ppdb'] ?? 0);
        $site = $this->getSiteName();

        $message = "PENGUMUMAN HASIL PPDB\n";
        $message .= "{$site}\n\n";
        $message .= "Kepada Yth. *{$nama}*\n";
        $message .= "No. Pendaftaran: #{$id}\n";
        $message .= "Status: *{$status}*\n\n";

        if ($status === 'Diterima') {
            $message .= "Berdasarkan hasil verifikasi, Anda dinyatakan *DITERIMA* sebagai calon peserta didik baru.\n";
            $message .= "Silakan melakukan daftar ulang sesuai jadwal yang ditentukan.";
        } else {
            $message .= "Berdasarkan hasil verifikasi, Anda dinyatakan *TIDAK DITERIMA* pada periode PPDB ini.\n";
            $message .= "Terima kasih atas partisipasi Anda. Tetap semangat dan sukses selalu.";
        }

        return $message;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone) ?? '';

        if ($phone === '') {
            return '';
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

}
