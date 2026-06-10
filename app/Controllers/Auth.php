<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ─── GET /login ───────────────────────────────────────────────
    public function login(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', array_merge($this->data, [
            'title'   => 'Login Admin',
            'error'   => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ]));
    }

    // ─── POST /login/proses ───────────────────────────────────────
    public function proses()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $isAjax   = $this->request->isAJAX();

        if (empty($username) || empty($password)) {
            $message = 'Username dan password wajib diisi.';
            
            if ($isAjax) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $message,
                ]);
            }
            
            return redirect()->to('/login')
                ->with('error', $message);
        }

        $userModel = new UserModel();
        $user      = $userModel->cekLogin($username, $password);

        if (! $user) {
            sleep(1);
            $message = 'Username atau password salah.';
            
            if ($isAjax) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $message,
                ]);
            }
            
            return redirect()->to('/login')
                ->with('error', $message)
                ->withInput();
        }

        session()->set([
            'logged_in'  => true,
            'user_id'    => $user['id'],
            'admin_user' => [
                'id'     => $user['id'],
                'nama'   => $user['nama'],
                'role'   => $user['role'],
                'email'  => $user['email'] ?? '',
                'avatar' => $user['avatar'] ?? strtoupper(substr($user['nama'], 0, 1)),
            ],
        ]);

        if ($isAjax) {
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Login berhasil! Mengalihkan...',
                'redirect' => base_url('/dashboard'),
                'user'     => [
                    'nama' => $user['nama'],
                    'role' => $user['role'],
                ],
            ]);
        }

        return redirect()->to('/dashboard');
    }

    // ─── GET /logout ──────────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')
            ->with('success', 'Anda berhasil keluar. Sampai jumpa!');
    }

    // ─── GET /forgot-password ──────────────────────────────────────
    public function forgotPassword(): string
    {
        return view('auth/forgot_password', array_merge($this->data, [
            'title'   => 'Lupa Password',
            'error'   => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ]));
    }

    // ─── POST /forgot-password/kirim ───────────────────────────────
    public function kirimResetLink()
    {
        $email = trim($this->request->getPost('email'));

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Email wajib diisi dengan format yang valid.')
                ->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            // Nonaktifkan proteksi ini sementara untuk testing
            return redirect()->to('/forgot-password')
                ->with('error', 'Email tidak ditemukan di database kami.');
        }

        // Generate reset token & simpan ke DB
        $resetToken = bin2hex(random_bytes(32));
        $tokenExpire = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $userModel->update($user['id'], [
            'reset_token'  => $resetToken,
            'token_expire' => $tokenExpire,
        ]);

        $resetLink = base_url('reset-password/' . $resetToken);
        $emailService = \Config\Services::email();

        // Bersihkan state email sebelumnya
        $emailService->clear(true);

        // Tambahkan newline dan CRLF agar kompatibel dengan standar SMTP Gmail
        $emailService->setNewline("\r\n");
        $emailService->setCRLF("\r\n");
        $emailService->setMailType('html');

        // Ambil konfigurasi dari Config\Email jika di .env tidak ada
        $emailConfig = config('Email');
        $fromEmail = env('email.fromEmail') ?: $emailConfig->fromEmail ?: env('email.SMTPUser') ?: $emailConfig->SMTPUser;
        $fromName  = env('email.fromName') ?: $emailConfig->fromName ?: 'SDN 56 Prabumulih';

        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setTo($user['email']);
        $emailService->setSubject('Reset Password Admin SDN 56 Prabumulih');

        // Pastikan view template 'emails/reset_password' sudah ada
        $emailService->setMessage(view('emails/reset_password', [
            'nama'       => $user['nama'] ?? 'Admin',
            'resetLink'  => $resetLink,
            'expireTime' => date('d M Y H:i', strtotime($tokenExpire)) . ' WIB',
            'siteName'   => $this->data['site_name'] ?? 'SDN 56 Prabumulih',
            'logoUrl'    => $this->data['logo_url'] ?? '',
        ]));

        if (! $emailService->send(false)) {
            $userModel->update($user['id'], [
                'reset_token'  => null,
                'token_expire' => null,
            ]);

            // Tampilkan semua detail SMTP untuk melihat pesan error asli dari server
            $debugger = $emailService->printDebugger();
            log_message('error', "[AUTH ERROR] Gagal kirim email reset ke {$user['email']}. Detail SMTP: " . $debugger);

            return redirect()->to('/forgot-password')
                ->with('error', 'Gagal mengirim email reset password. Periksa konfigurasi email lalu coba lagi.')
                ->withInput();
        }

        return redirect()->to('/forgot-password')
            ->with('success', 'Link reset password telah dikirim ke ' . $user['email']);
    }

    // ─── GET /reset-password/{token} ───────────────────────────────
    public function resetPassword($token = ''): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (empty($token)) {
            return redirect()->to('/login')->with('error', 'Token tidak valid.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau expired.');
        }

        // Cek apakah token masih berlaku
        if (strtotime($user['token_expire']) < time()) {
            return redirect()->to('/login')->with('error', 'Link reset sudah expired. Silakan minta link baru.');
        }

        return view('auth/reset_password', array_merge($this->data, [
            'title'   => 'Reset Password',
            'token'   => $token,
            'error'   => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ]));
    }

    // ─── POST /reset-password/simpan ───────────────────────────────
    public function simpanPasswordBaru()
    {
        $token           = trim($this->request->getPost('token'));
        $passwordBaru    = $this->request->getPost('password');
        $konfirmPassword = $this->request->getPost('confirm_password');

        if (empty($token) || empty($passwordBaru) || empty($konfirmPassword)) {
            return redirect()->back()
                ->with('error', 'Semua field wajib diisi.')
                ->withInput();
        }

        if ($passwordBaru !== $konfirmPassword) {
            return redirect()->back()
                ->with('error', 'Password dan konfirmasi password tidak cocok.')
                ->withInput();
        }

        if (strlen($passwordBaru) < 6) {
            return redirect()->back()
                ->with('error', 'Password minimal 6 karakter.')
                ->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau expired.');
        }

        // Cek token expire
        if (strtotime($user['token_expire']) < time()) {
            return redirect()->to('/login')->with('error', 'Link reset sudah expired. Silakan minta link baru.');
        }

        // Update password & clear token
        $userModel->update($user['id'], [
            'password'     => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'reset_token'  => null,
            'token_expire' => null,
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
