<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – Admin SD Negeri 56 Prabumulih</title>
<link rel="icon" type="image/png" href="<?= $logo_url ?>">
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
        <img src="<?= $logo_url ?>" alt="Logo SDN 56">
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
        <div class="lf-welcome">Selamat Datang</div>
        <div class="lf-title">Masuk ke<br>Admin Panel</div>
        <p class="lf-sub">Silakan masuk dengan akun yang telah diberikan oleh Administrator.</p>

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

        <form id="loginForm" autocomplete="off">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Username</label>
            <div class="input-wrap">
            <span class="input-icon">👤</span>
            <input type="text" id="username" name="username"
                    placeholder="Masukkan username"
                    value="<?= old('username') ?>"
                    autocomplete="username" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" id="password" name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password" required>
            <span class="pw-toggle" id="pwToggle" onclick="togglePw()">👁️</span>
            </div>
        </div>

        <div class="form-check">
            <label><input type="checkbox" name="remember"> Ingat saya</label>
            <a href="<?= base_url('forgot-password') ?>">Lupa password?</a>
        </div>

        <button type="submit" class="btn-login" id="btnLogin">
            <span class="btn-txt" id="btnTxt">🔐 Masuk</span>
            <span class="btn-loader" id="btnLoader" style="display:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" opacity="0.3"></circle>
                    <path d="M12 2a10 10 0 0110 10" stroke-dasharray="31.4" stroke-dashoffset="31.4" stroke-linecap="round">
                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"></animateTransform>
                    </path>
                </svg>
            </span>
        </button>
        </form>

        <div class="login-success" id="loginSuccess" style="display:none;">
            <div class="success-icon">✅</div>
            <div class="success-title">Login Berhasil!</div>
            <div class="success-desc" id="successDesc"></div>
            <div class="success-redirect">
                <span id="redirectMsg">Mengalihkan ke dashboard dalam <span id="countDown">3</span> detik...</span>
            </div>
        </div>

        <div class="lf-footer">© <?= date('Y') ?> <span>SD Negeri 56 Prabumulih</span> · Admin Panel v1.0</div>
    </div>
    </div>

<script>
    // Toggle password visibility
    function togglePw() {
        const pw = document.getElementById('password');
        const tg = document.getElementById('pwToggle');
        const show = pw.type === 'password';
        pw.type        = show ? 'text' : 'password';
        tg.textContent = show ? '🙈' : '👁️';
    }

    // Handle login form submission
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const btnLogin = document.getElementById('btnLogin');
        const btnTxt = document.getElementById('btnTxt');
        const btnLoader = document.getElementById('btnLoader');
        const loginAlert = document.querySelector('.login-alert');

        // Validasi input
        if (!username || !password) {
            showAlert('⚠️ Username dan password wajib diisi.', 'error');
            return;
        }

        // Disable button & show loader
        btnLogin.disabled = true;
        btnTxt.style.display = 'none';
        btnLoader.style.display = 'inline-block';

        // Remove previous alerts
        if (loginAlert) loginAlert.remove();

        try {
            // Get CSRF token from hidden input
            const csrfName = document.querySelector('input[name*="csrf"]').name;
            const csrfHash = document.querySelector('input[name*="csrf"]').value;

            const formData = new URLSearchParams();
            formData.append('username', username);
            formData.append('password', password);
            formData.append(csrfName, csrfHash);

            const response = await fetch('<?= base_url('login/proses') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                // Show success message
                showSuccessScreen(data);
                
                // Redirect after 3 seconds
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 3000);
            } else {
                // Show error message
                showAlert(data.message, 'error');
                btnLogin.disabled = false;
                btnTxt.style.display = 'inline';
                btnLoader.style.display = 'none';
            }
        } catch (error) {
            showAlert('⚠️ Terjadi kesalahan. Silakan coba lagi.', 'error');
            btnLogin.disabled = false;
            btnTxt.style.display = 'inline';
            btnLoader.style.display = 'none';
        }
    });

    // Show alert message
    function showAlert(message, type = 'error') {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'login-alert show';
        if (type === 'error') {
            alertDiv.innerHTML = message;
        } else {
            alertDiv.innerHTML = message;
        }
        alertDiv.style.marginBottom = '16px';
        
        const formGroup = document.querySelector('.form-group');
        formGroup.parentNode.insertBefore(alertDiv, formGroup);

        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.classList.remove('show');
            setTimeout(() => alertDiv.remove(), 300);
        }, 5000);
    }

    // Show success screen
    function showSuccessScreen(data) {
        const loginForm = document.getElementById('loginForm');
        const loginSuccess = document.getElementById('loginSuccess');
        const successDesc = document.getElementById('successDesc');

        loginForm.style.display = 'none';
        loginSuccess.style.display = 'block';
        successDesc.textContent = `Selamat datang, ${data.user.nama}! (${data.user.role})`;

        // Countdown timer
        let count = 3;
        const countdownInterval = setInterval(() => {
            count--;
            document.getElementById('countDown').textContent = count;
            if (count <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);
    }
</script>

<style>
    .btn-loader {
        display: inline-block;
        margin-right: 8px;
    }

    .btn-loader svg {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .login-success {
        text-align: center;
        padding: 40px 20px;
        animation: slideUp 0.4s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        font-size: 48px;
        margin-bottom: 16px;
        animation: bounce 0.6s ease-out;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .success-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--success);
        margin-bottom: 8px;
    }

    .success-desc {
        font-size: 13px;
        color: var(--gray);
        margin-bottom: 24px;
    }

    .success-redirect {
        font-size: 12px;
        color: var(--gray);
        font-style: italic;
    }
</style>
</body>
</html>