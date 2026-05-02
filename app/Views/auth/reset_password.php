<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password – Admin SD Negeri 56 Prabumulih</title>
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
        <div class="lb-pill">⚙️ Pengaturan</div>
        </div>
    </div>

    <!-- Right form -->
    <div class="login-form-panel">
        <div class="lf-welcome">Buat Password Baru</div>
        <div class="lf-title">Reset Password<br>Anda</div>
        <p class="lf-sub">Masukkan password baru yang kuat untuk akun Anda.</p>

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

        <form action="<?= base_url('reset-password/simpan') ?>" method="POST" autocomplete="off">
        <?= csrf_field() ?>
        <input type="hidden" name="token" value="<?= $token ?>">

        <div class="form-group">
            <label for="password">Password Baru</label>
            <div class="input-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" id="password" name="password"
                    placeholder="Masukkan password baru"
                    autocomplete="new-password" required>
            <span class="pw-toggle" id="pwToggle1" onclick="togglePw('password', 'pwToggle1')">👁️</span>
            </div>
            <small style="color:#999;margin-top:6px;display:block">Minimal 6 karakter</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password</label>
            <div class="input-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" id="confirm_password" name="confirm_password"
                    placeholder="Konfirmasi password baru"
                    autocomplete="new-password" required>
            <span class="pw-toggle" id="pwToggle2" onclick="togglePw('confirm_password', 'pwToggle2')">👁️</span>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <span class="btn-txt">🔐 Reset Password</span>
        </button>
        </form>

        <div style="text-align:center;margin-top:20px;font-size:13px">
        <a href="<?= base_url('login') ?>" style="color:#666;text-decoration:none;transition:color 0.2s">← Kembali ke Login</a>
        </div>

        <div class="lf-footer">© <?= date('Y') ?> <span>SD Negeri 56 Prabumulih</span> · Admin Panel v1.0</div>
    </div>
    </div>

<script>
    function togglePw(fieldId, toggleId) {
    const field = document.getElementById(fieldId);
    const tg = document.getElementById(toggleId);
    const show = field.type === 'password';
    field.type         = show ? 'text' : 'password';
    tg.textContent = show ? '🙈' : '👁️';
    }
</script>
</body>
</html>
