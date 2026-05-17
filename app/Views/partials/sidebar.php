    <?php
    $uri         = service('uri');
    $currentPage = $uri->getSegment(1) ?: 'dashboard';
    $currentPath = $uri->getSegment(1) . ($uri->getSegment(2) ? '/' . $uri->getSegment(2) : '');
    $adminUser   = $admin_user ?? ['nama' => 'Admin', 'role' => '', 'avatar' => 'A'];

    // Test apakah helper ter-load
    if (!function_exists('canAccess')) {
        // Jika belum, load manual
        require_once APPPATH . 'Helpers/PermissionHelper.php';
    }

    $menu = [
    ['page'=>'dashboard','icon'=>'📊','label'=>'Dashboard',           'badge'=>0, 'resource'=>'dashboard'],
    ['page'=>'berita',   'icon'=>'📰','label'=>'Berita & Konten',     'badge'=>2, 'resource'=>'berita'],
    ['page'=>'ppdb',     'icon'=>'✏️','label'=>'Data PPDB',           'badge'=>2, 'resource'=>'ppdb'],
    ['page'=>'ppdb/report','icon'=>'📈','label'=>'Laporan PPDB',      'badge'=>0, 'resource'=>'ppdb'],
    ['page'=>'ppdb/laporan','icon'=>'📋','label'=>'Laporan Tahunan',  'badge'=>0, 'resource'=>'ppdb'],
    ['page'=>'agenda',   'icon'=>'📅','label'=>'Agenda & Kegiatan',  'badge'=>0, 'resource'=>'agenda'],
    ['page'=>'galeri',   'icon'=>'🖼️','label'=>'Galeri Foto',         'badge'=>0, 'resource'=>'galeri'],
    ['page'=>'guru',     'icon'=>'👨‍🏫','label'=>'Guru & Staf',        'badge'=>0, 'resource'=>'guru'],
    ];
    $menuSistem = [
    ['page'=>'settings','icon'=>'⚙️','label'=>'Pengaturan', 'resource'=>'settings'],
    ];
    ?>
    <aside class="sidebar" id="sidebar">
    <div class="sb-head">
        <img class="sb-logo" src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
        <div class="sb-name">
        <strong>SDN 56 Prabumulih</strong>
        <span>Admin Panel</span>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Menu Utama</div>
        <?php foreach ($menu as $m): ?>
            <?php 
            try {
                $hasAccess = canAccess($m['resource']);
            } catch (Exception $e) {
                $hasAccess = true; // Default allow jika error
            }
            
            // Check if current page matches menu page (support multi-segment routes)
            $isActive = ($currentPath === $m['page']) || ($currentPage === $m['page']);
            ?>
            <?php if ($hasAccess): ?>
            <a href="<?= base_url($m['page']) ?>"
            class="sb-item <?= $isActive ? 'active' : '' ?>">
            <span class="sb-ic"><?= $m['icon'] ?></span>
            <span class="sb-lbl"><?= esc($m['label']) ?></span>
            <?php if ($m['badge'] > 0): ?>
            <span class="sb-badge"><?= $m['badge'] ?></span>
            <?php endif; ?>
            </a>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="sb-section">Sistem</div>
        <?php foreach ($menuSistem as $m): ?>
            <?php 
            try {
                $hasAccess = canAccess($m['resource']);
            } catch (Exception $e) {
                $hasAccess = false; // Untuk settings, default deny
            }
            
            // Check if current page matches menu page
            $isActive = ($currentPath === $m['page']) || ($currentPage === $m['page']);
            ?>
            <?php if ($hasAccess): ?>
            <a href="<?= base_url($m['page']) ?>"
            class="sb-item <?= $isActive ? 'active' : '' ?>">
            <span class="sb-ic"><?= $m['icon'] ?></span>
            <span class="sb-lbl"><?= esc($m['label']) ?></span>
            </a>
            <?php endif; ?>
        <?php endforeach; ?>

        <a href="<?= esc($web_url ?? 'http://localhost:8080') ?>" target="_blank" class="sb-item">
        <span class="sb-ic">🌐</span>
        <span class="sb-lbl">Lihat Website</span>
        </a>
    </nav>

    <div class="sb-footer">
        <?php 
        try {
            $canAccessSettings = canAccess('settings');
        } catch (Exception $e) {
            $canAccessSettings = false;
        }
        ?>
        <a href="<?= $canAccessSettings ? base_url('settings') : '#' ?>" class="sb-user" <?= !$canAccessSettings ? 'style="cursor:not-allowed;opacity:0.7;"' : '' ?>>
        <div class="sb-avatar"><?= esc($adminUser['avatar'] ?? 'A') ?></div>
        <div class="sb-user-info">
            <div class="sb-user-name"><?= esc($adminUser['nama'] ?? 'Admin') ?></div>
            <div class="sb-user-role"><?= esc($adminUser['role'] ?? '') ?></div>
        </div>
        </a>
    </div>
    </aside>