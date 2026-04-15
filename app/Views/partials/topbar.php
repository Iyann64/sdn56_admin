    <?php $adminUser = $admin_user ?? ['nama' => 'Admin', 'role' => '', 'avatar' => 'A']; ?>
    <header class="topbar">

    <!-- Mobile hamburger -->
    <button style="display:none;flex-direction:column;gap:4px;padding:8px;border-radius:8px;background:var(--light);margin-right:8px"
            id="mobileHam" onclick="openMobileSidebar()">
        <span style="display:block;width:20px;height:2px;background:var(--ink);border-radius:2px"></span>
        <span style="display:block;width:20px;height:2px;background:var(--ink);border-radius:2px"></span>
        <span style="display:block;width:20px;height:2px;background:var(--ink);border-radius:2px"></span>
    </button>
    <style>@media(max-width:900px){#mobileHam{display:flex!important}}</style>

    <div>
        <div class="tb-title">
        <span class="page-icon"><?= esc($page_icon ?? '📄') ?></span>
        <span><?= esc($title ?? 'Admin') ?></span>
        </div>
        <div class="tb-breadcrumb">Admin Panel › <span><?= esc($title ?? '') ?></span></div>
    </div>

    <div class="tb-right">
        <div class="tb-search">
        <span>🔍</span>
        <input type="text" placeholder="Cari sesuatu...">
        </div>
        <div class="tb-icon-btn" onclick="showToast('info','Tidak ada notifikasi baru.')">
        🔔<div class="tb-notif-dot"></div>
        </div>
        <div class="dropdown">
        <div class="tb-profile" onclick="toggleDropdown()">
            <div class="tb-avatar"><?= esc($adminUser['avatar'] ?? 'A') ?></div>
            <span class="tb-uname"><?= esc($adminUser['nama'] ?? 'Admin') ?></span>
            <span style="color:var(--gray);font-size:12px">▾</span>
        </div>
        <div class="dropdown-menu" id="profileDropdown">
            <a class="dd-item" href="<?= base_url('settings') ?>">⚙️ Pengaturan</a>
            <div class="dd-divider"></div>
            <a class="dd-item danger" href="<?= base_url('logout') ?>">🚪 Keluar</a>
        </div>
        </div>
    </div>
    </header>