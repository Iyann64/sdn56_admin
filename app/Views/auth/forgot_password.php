<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password – Admin SD Negeri 56 Prabumulih</title>
<link rel="icon" type="image/jpeg" href="<?= base_url('assets/img/logo.jpg') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-style.css') ?>">
</head>
<body>

    <div class="login-page">
    <div class="login-bg-grid"></div>
    <div class="lo1 login-orb"></div>
    <div class="lo2 login-orb"></div>

    <!-- Left branding -->
    <div class="login-brand">
        <div class="lb-logo-ring">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo SDN 56">
        </div>
        <div class="lb-title">SD Negeri 56<br>Prabumulih</div>
        <p class="lb-sub">Panel administrasi resmi untuk mengelola konten, data PPDB, agenda, dan informasi sekolah secara terpusat.</p>
        <div class="lb-pills">
        <div class="lb-pill">📊 Manajemen Data</div>
        <div class="lb-pill">📰 Kelola Berita</div>
        <div class="lb-pill">✏️ PPDB Online</div>
        <div class="lb-pill">🖼️ Galeri</div>
        <div class="lb-pill">📅 Agenda</div>
        <div class="lb-pill">⚙️ Pengaturan</div>
        </div>
    </div>

    <!-- Right form -->
    <div class="login-form-panel">
        <div class="lf-welcome">Lupa Password?</div>
        <div class="lf-title">Reset Password<br>Anda</div>
        <p class="lf-sub">Masukkan email Anda, kami akan mengirimkan link untuk reset password ke email Anda.</p>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="login-alert show">
        ⚠️ <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#E8F5E9;border-radius:10px;padding:12px 16px;font-size:13px;color:#2E7D32;margin-bottom:16px;border-left:3px solid #43A047">
        ✅ <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('forgot-password/kirim') ?>" method="POST" autocomplete="off">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrap">
            <span class="input-icon">📧</span>
            <input type="email" id="email" name="email"
                    placeholder="Masukkan email Anda"
                    value="<?= old('email') ?>"
                    autocomplete="email" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <span class="btn-txt">📨 Kirim Link Reset</span>
        </button>
        </form>

        <div style="text-align:center;margin-top:20px;font-size:13px">
        <a href="<?= base_url('login') ?>" style="color:#666;text-decoration:none;transition:color 0.2s">← Kembali ke Login</a>
        </div>

        <div class="lf-footer">© <?= date('Y') ?> <span>SD Negeri 56 Prabumulih</span> · Admin Panel v1.0</div>
    </div>
    </div>

</body>
</html>
