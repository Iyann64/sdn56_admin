# 📧 Panduan Implementasi Fitur Lupa Password

## 📋 Daftar Isi
1. [Ringkasan Implementasi](#ringkasan)
2. [File yang Dibuat](#file-yang-dibuat)
3. [File yang Dimodifikasi](#file-yang-dimodifikasi)
4. [Alur Kerja Lupa Password](#alur-kerja)
5. [Implementasi Email Sending](#email-sending)
6. [Cara Menggunakan](#cara-menggunakan)
7. [Troubleshooting](#troubleshooting)

---

## <a id="ringkasan"></a>📝 Ringkasan Implementasi

Fitur **Lupa Password** telah diimplementasikan dengan alur lengkap:

1. **Form Lupa Password** - User memasukkan email
2. **Generate Token Reset** - Sistem membuat token unik untuk reset
3. **Email Notification** - Token dikirim via email (perlu konfigurasi)
4. **Reset Password** - User membuat password baru dengan token yang valid

---

## <a id="file-yang-dibuat"></a>✨ File yang Dibuat

### 1. **app/Database/Migrations/2024_01_01_000000_AddResetPasswordToUsers.php**
```php
// Menambah 2 kolom di tabel users:
// - reset_token (VARCHAR 64) - Menyimpan token unik untuk reset
// - token_expire (DATETIME) - Waktu berlaku token (24 jam)
```

**Cara menjalankan migration:**
```bash
php spark migrate
```

### 2. **app/Views/auth/forgot_password.php**
- Form untuk memasukkan email
- Layout yang konsisten dengan login page
- Display error/success messages

### 3. **app/Views/auth/reset_password.php**
- Form untuk memasukkan password baru
- Input field untuk konfirmasi password
- Password visibility toggle
- Form validation untuk panjang password (min 6 karakter)

---

## <a id="file-yang-dimodifikasi"></a>🔧 File yang Dimodifikasi

### 1. **app/Config/Routes.php**
**Route baru ditambahkan:**
```
GET  /forgot-password              → Auth::forgotPassword()
POST /forgot-password/kirim        → Auth::kirimResetLink()
GET  /reset-password/{token}       → Auth::resetPassword($token)
POST /reset-password/simpan        → Auth::simpanPasswordBaru()
```

### 2. **app/Controllers/Auth.php**
**Method baru ditambahkan:**
- `forgotPassword()` - Tampilkan form lupa password
- `kirimResetLink()` - Generate token & kirim email (TODO: implementasi email)
- `resetPassword($token)` - Tampilkan form reset dengan validasi token
- `simpanPasswordBaru()` - Update password & clear token

### 3. **app/Views/auth/login.php**
**Perubahan:**
- Link "Lupa password?" diubah dari `#` menjadi `<?= base_url('forgot-password') ?>`

---

## <a id="alur-kerja"></a>🔄 Alur Kerja Lupa Password

```
┌─────────────────────────────────────────────────────┐
│ 1. User di Login Page                               │
│    Klik "Lupa password?"                            │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 2. Forgot Password Form                             │
│    - User masukkan email                            │
│    - Klik "Kirim Link Reset"                        │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 3. Sistem Generate Token                            │
│    - Generate random token 64-char                  │
│    - Set expiry 24 jam dari sekarang                │
│    - Simpan ke DB di kolom reset_token & token_    │
│      expire                                         │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 4. TODO: Kirim Email ← PERLU DIKONFIGURASI         │
│    - Buat email template dengan link reset          │
│    - Kirim ke email user dengan token              │
│    - Link format: /reset-password/{token}           │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 5. User Klik Link di Email                          │
│    - URL: /reset-password/{token}                   │
│    - Validasi token ada di DB & belum expired       │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 6. Reset Password Form                              │
│    - User masukkan password baru                    │
│    - Masukkan konfirmasi password                   │
│    - Klik "Reset Password"                          │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 7. Sistem Update Password                           │
│    - Hash password dengan bcrypt                    │
│    - Clear kolom reset_token & token_expire         │
│    - Redirect ke login dengan success message       │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│ 8. Selesai                                          │
│    - User bisa login dengan password baru           │
└─────────────────────────────────────────────────────┘
```

---

## <a id="email-sending"></a>📨 Implementasi Email Sending

### Langkah 1: Konfigurasi Email di `.env`

Buka file `.env` di root project:
```
app.baseURL = 'http://localhost:8080/'

# Email Configuration
email.protocol = 'smtp'
email.SMTPHost = 'smtp.gmail.com'      # atau server email Anda
email.SMTPUser = 'your-email@gmail.com'
email.SMTPPass = 'your-app-password'   # Gunakan App Password jika Gmail
email.SMTPPort = 587
email.SMTPCrypto = 'tls'
email.mailType = 'html'
email.charset = 'UTF-8'
email.newline = '\r\n'
```

### Langkah 2: Update Method `kirimResetLink()` di Auth Controller

Ganti code ini di `app/Controllers/Auth.php`:

```php
// ─── POST /forgot-password/kirim ───────────────────────────
public function kirimResetLink()
{
    $email = trim($this->request->getPost('email'));

    if (empty($email)) {
        return redirect()->to('/forgot-password')
            ->with('error', 'Email wajib diisi.')
            ->withInput();
    }

    $userModel = new UserModel();
    $user = $userModel->where('email', $email)->first();

    if (!$user) {
        // Keamanan: jangan beri tahu email tidak terdaftar
        return redirect()->to('/forgot-password')
            ->with('success', 'Jika email terdaftar, link reset akan dikirim ke email Anda.');
    }

    // Generate reset token & simpan ke DB
    $resetToken = bin2hex(random_bytes(32));
    $tokenExpire = date('Y-m-d H:i:s', strtotime('+24 hours'));

    $userModel->update($user['id'], [
        'reset_token'  => $resetToken,
        'token_expire' => $tokenExpire,
    ]);

    // ========== KIRIM EMAIL ==========
    $email_service = \Config\Services::email();
    
    $email_service->setFrom('noreply@sdn56prabumulih.id', 'Admin SDN 56 Prabumulih')
        ->setTo($user['email'])
        ->setSubject('Link Reset Password - Admin SDN 56 Prabumulih')
        ->setMessage(view('emails/reset_link', [
            'nama'       => $user['nama'],
            'resetLink'  => base_url('reset-password/' . $resetToken),
            'expireTime' => date('d F Y H:i', strtotime($tokenExpire)),
        ]));

    if (!$email_service->send(false)) {
        log_message('error', 'Failed to send reset email: ' . $email_service->printDebugger(['headers']));
        return redirect()->to('/forgot-password')
            ->with('error', 'Gagal mengirim email. Silakan coba lagi nanti.');
    }

    return redirect()->to('/forgot-password')
        ->with('success', 'Jika email terdaftar, link reset akan dikirim ke email Anda.');
}
```

### Langkah 3: Buat Email Template

Buat file baru: `app/Views/emails/reset_link.php`

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 10px;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #1a237e; margin: 0;">Reset Password</h1>
            <p style="color: #666; font-size: 14px;">Admin SDN 56 Prabumulih</p>
        </div>

        <!-- Content -->
        <div style="background: white; padding: 30px; border-radius: 8px; border-left: 4px solid #1a237e;">
            <p>Halo <strong><?= $nama ?></strong>,</p>
            
            <p>Kami menerima permintaan untuk reset password akun Anda di Admin Panel SDN 56 Prabumulih.</p>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="<?= $resetLink ?>" 
                   style="display: inline-block; padding: 12px 30px; background: #1a237e; color: white; text-decoration: none; border-radius: 5px; font-weight: 600;">
                    🔐 Reset Password Saya
                </a>
            </p>

            <p><strong>Atau salin link berikut:</strong></p>
            <p style="background: #f5f5f5; padding: 12px; border-radius: 5px; word-break: break-all; font-size: 12px;">
                <?= $resetLink ?>
            </p>

            <p style="color: #d32f2f; font-size: 13px;">
                ⏰ <strong>Link ini berlaku hingga:</strong> <?= $expireTime ?>
            </p>

            <p style="color: #666; font-size: 13px; margin-top: 20px;">
                ℹ️ Jika Anda tidak meminta reset password, abaikan email ini. Link reset akan otomatis hangus dalam 24 jam.
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #999;">
            <p>© <?= date('Y') ?> SD Negeri 56 Prabumulih. All rights reserved.</p>
            <p>Jangan pernah bagikan link ini ke orang lain.</p>
        </div>
    </div>
</body>
</html>
```

---

## <a id="cara-menggunakan"></a>🚀 Cara Menggunakan

### Untuk Pengguna:

1. **Di halaman Login**, klik link **"Lupa password?"**
2. **Masukkan email** yang terdaftar di sistem
3. **Cek email Anda** untuk link reset (periksa folder Spam jika tidak ada di Inbox)
4. **Klik link** di email untuk membuka form reset
5. **Masukkan password baru** dan konfirmasi
6. **Klik "Reset Password"** untuk menyimpan
7. **Login dengan password baru** Anda

### Untuk Administrator (Konfigurasi):

1. **Jalankan Migration:**
   ```bash
   php spark migrate
   ```

2. **Konfigurasi Email di `.env`** (lihat bagian Email Sending)

3. **Update Auth Controller** dengan code email sending (lihat bagian Email Sending)

4. **Buat Email Template** di `app/Views/emails/reset_link.php`

5. **Testing:**
   - Akses http://localhost:8080/forgot-password
   - Masukkan email admin
   - Cek logs di `writable/logs/` jika email gagal

---

## <a id="troubleshooting"></a>🛠️ Troubleshooting

### ❌ Halaman /forgot-password tidak ditemukan
**Solusi:** Pastikan route sudah ditambahkan ke `app/Config/Routes.php`

### ❌ Form lupa password tidak tampil dengan style yang benar
**Solusi:** Pastikan `app/Views/auth/forgot_password.php` sudah ada dengan file yang benar

### ❌ Email tidak terkirim
**Solusi:**
1. Cek konfigurasi `.env` - pastikan SMTP settings benar
2. Cek `writable/logs/` untuk error messages
3. Jika pakai Gmail, gunakan **App Password** bukan password biasa
4. Pastikan `app/Views/emails/reset_link.php` sudah dibuat

### ❌ Token sudah expired saat user klik link
**Solusi:** Token berlaku 24 jam. Bisa ubah di method `kirimResetLink()` di baris:
```php
$tokenExpire = date('Y-m-d H:i:s', strtotime('+24 hours')); // Ubah durasi di sini
```

### ❌ Password tidak bisa direset dengan error "Token tidak valid"
**Solusi:**
1. Pastikan migration sudah dijalankan: `php spark migrate`
2. Pastikan token masih berlaku (belum lebih dari 24 jam)
3. Cek database kolom `reset_token` dan `token_expire` sudah ada di tabel `users`

---

## ✅ Validasi Implementasi

Fitur sudah diimplementasikan dengan:
- ✅ Form lupa password dengan email input
- ✅ Token generation dengan random 64-char
- ✅ Token expiry (24 jam)
- ✅ Form reset password dengan validation
- ✅ Password hashing dengan bcrypt (PASSWORD_DEFAULT)
- ✅ Email template siap pakai
- ✅ Error handling & security checks
- ✅ UI konsisten dengan design login

---

## 📞 Catatan Penting

**KEAMANAN:**
- Token hanya digunakan sekali dan dihapus setelah reset berhasil
- Token berlaku 24 jam kemudian otomatis expired
- Password di-hash dengan bcrypt (PASSWORD_DEFAULT)
- Pesan error generic untuk mencegah user enumeration
- Email hanya dikirim ke email terdaftar di database

---

**Dibuat untuk:** SDN 56 Prabumulih Admin Panel  
**Framework:** CodeIgniter 4  
**Database:** MySQL/MariaDB
