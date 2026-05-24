<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
        .container { max-width: 680px; margin: 0 auto; padding: 20px; }
        .card { background: #ffffff; border: 1px solid #d9d9d9; border-radius: 12px; overflow: hidden; }
        .header { background: #0f4c5c; color: #ffffff; text-align: center; padding: 22px 20px; }
        .header h2 { margin: 0 0 8px; font-size: 24px; }
        .header p { margin: 0; font-size: 14px; opacity: 0.95; }
        .content { padding: 24px; }
        .notice { padding: 14px 16px; border-radius: 10px; font-weight: 700; text-align: center; margin: 18px 0; }
        .diterima { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .ditolak { background-color: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
        .meta { width: 100%; font-size: 14px; border-collapse: collapse; margin-top: 20px; }
        .meta td { padding: 8px 0; border-bottom: 1px solid #eee; }
        .footer { text-align: center; font-size: 12px; color: #777; padding: 18px 24px 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>PENGUMUMAN HASIL PPDB</h2>
                <p><?= esc($site_name) ?></p>
            </div>
            <div class="content">
                <p>Kepada Yth. <strong><?= esc($nama) ?></strong>,</p>

                <?php if ($status === 'Diterima'): ?>
                    <div class="notice diterima">PENGUMUMAN: Anda dinyatakan <strong>DITERIMA</strong></div>
                    <p>Berdasarkan hasil verifikasi berkas dan pertimbangan panitia PPDB, calon peserta didik dengan data di bawah ini resmi <strong>DITERIMA</strong> sebagai siswa baru di <?= esc($site_name) ?>.</p>
                    <p>Silakan melakukan daftar ulang sesuai jadwal dan membawa dokumen asli yang diperlukan.</p>
                <?php else: ?>
                    <div class="notice ditolak">PENGUMUMAN: Anda dinyatakan <strong>TIDAK DITERIMA</strong></div>
                    <p>Berdasarkan hasil verifikasi berkas dan pertimbangan panitia PPDB, calon peserta didik dengan data di bawah ini belum dapat <strong>DITERIMA</strong> pada periode PPDB kali ini.</p>
                    <p>Terima kasih atas partisipasi Anda. Tetap semangat dan semoga sukses di kesempatan berikutnya.</p>
                <?php endif; ?>

                <table class="meta">
                    <tr>
                        <td style="width: 180px;">No. Pendaftaran</td>
                        <td>: <strong>#<?= esc((string) $id_ppdb) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Nama Calon Siswa</td>
                        <td>: <?= esc($nama) ?></td>
                    </tr>
                    <tr>
                        <td>Status Pengumuman</td>
                        <td>: <strong><?= esc($status) ?></strong></td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <p>Pengumuman ini dikirim otomatis oleh sistem PPDB <?= esc($site_name) ?>.<br>
                Jika ada pertanyaan, silakan hubungi panitia PPDB sekolah.</p>
                <p>&copy; <?= date('Y') ?> <?= esc($site_name) ?></p>
            </div>
        </div>
    </div>
</body>
</html>
