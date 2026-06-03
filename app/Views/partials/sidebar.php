    <?php
    $uri         = service('uri');
    $segments    = $uri->getSegments();
    $currentPage = $segments[0] ?? 'dashboard';
    $currentPath = $segments[0] ?? '';
    if (isset($segments[1])) {
        $currentPath .= '/' . $segments[1];
    }
    $adminUser   = $admin_user ?? ['nama' => 'Admin', 'role' => '', 'avatar' => 'A'];

    // Test apakah helper ter-load
    if (!function_exists('canAccess')) {
        // Jika belum, load manual
        require_once APPPATH . 'Helpers/PermissionHelper.php';
    }

    $menu = [
    ['page'=>'dashboard','icon'=>'📊','label'=>'Dashboard',           'badge'=>0, 'resource'=>'dashboard'],
    ['page'=>'berita',   'icon'=>'📰','label'=>'Berita & Konten',     'badge'=>2, 'resource'=>'berita'],
    [
        'label'    => 'PPDB', 
        'icon'     => '✏️', 
        'resource' => 'ppdb',
        'sub'      => [
            ['page'=>'ppdb',             'icon' => '👥', 'label'=>'Daftar PPDB', 'badge'=>2, 'resource'=>'ppdb'],
            ['page'=>'ppdb/report',      'icon' => '📈', 'label'=>'Statistik & Grafik', 'badge'=>0, 'resource'=>'ppdb_report'],
            ['page'=>'ppdb/laporan',     'icon' => '📂', 'label'=>'Laporan Tahunan',  'badge'=>0, 'resource'=>'ppdb_laporan'],
            ['page'=>'ppdb/persyaratan', 'icon' => '📜', 'label'=>'Syarat Dokumen',    'badge'=>0, 'resource'=>'ppdb_konten'],
            ['page'=>'ppdb/jadwal',      'icon' => '🗓️', 'label'=>'Jadwal PPDB',       'badge'=>0, 'resource'=>'ppdb_konten'],
        ]
    ],
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
        <img class="sb-logo" src="<?= base_url('assets/img/logo-website-removebg-preview.png') ?>" alt="Logo">
        <div class="sb-name">
        <strong>SDN 56 Prabumulih</strong>
        <span>Admin Panel</span>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Menu Utama</div>
        <?php foreach ($menu as $m): ?>
            <?php if (isset($m['sub'])): ?>
                <?php 
                $isSubActive = false;
                foreach ($m['sub'] as $sub) {
                    if (($currentPath === $sub['page']) || ($currentPage === $sub['page'])) {
                        $isSubActive = true; break;
                    }
                }
                $hasAnyAccess = false;
                foreach ($m['sub'] as $sub) {
                    try { if (canAccess($sub['resource'])) { $hasAnyAccess = true; break; } } 
                    catch (Exception $e) { $hasAnyAccess = true; break; }
                }
                ?>
                <?php if ($hasAnyAccess): ?>
                    <div class="sb-item-group <?= $isSubActive ? 'open active' : '' ?>">
                        <div class="sb-item sb-drop-toggle" style="cursor:pointer;" onclick="this.parentElement.classList.toggle('open')">
                            <span class="sb-ic"><?= $m['icon'] ?></span>
                            <span class="sb-lbl"><?= esc($m['label']) ?></span>
                            <span class="sb-arrow" style="margin-left:auto; font-size:10px; transition:transform .3s;">▼</span>
                        </div>
                        <div class="sb-sub-menu" style="display:<?= $isSubActive ? 'block' : 'none' ?>; padding-left:10px; background:rgba(0,0,0,0.02);">
                            <?php foreach ($m['sub'] as $sub): ?>
                                <?php try { $hasSubAccess = canAccess($sub['resource']); } catch (Exception $e) { $hasSubAccess = true; } ?>
                                <?php if ($hasSubAccess): ?>
                                    <?php $isActiveSub = ($currentPath === $sub['page']) || ($currentPage === $sub['page']); ?>
                                    <a href="<?= base_url($sub['page']) ?>" class="sb-item <?= $isActiveSub ? 'active' : '' ?>" style="height:38px; font-size:12.5px;">
                                        <?php if (isset($sub['icon'])): ?>
                                            <span class="sb-ic" style="font-size:14px; width:20px; opacity:0.8;"><?= $sub['icon'] ?></span>
                                        <?php endif; ?>
                                        <span class="sb-lbl"><?= esc($sub['label']) ?></span>
                                        <?php if (isset($sub['badge']) && $sub['badge'] > 0): ?>
                                            <span class="sb-badge"><?= $sub['badge'] ?></span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php 
                try { $hasAccess = canAccess($m['resource']); } catch (Exception $e) { $hasAccess = true; }
                $isActive = ($currentPath === $m['page']) || ($currentPage === $m['page']);
                ?>
                <?php if ($hasAccess): ?>
                    <a href="<?= base_url($m['page']) ?>" class="sb-item <?= $isActive ? 'active' : '' ?>">
                        <span class="sb-ic"><?= $m['icon'] ?></span>
                        <span class="sb-lbl"><?= esc($m['label']) ?></span>
                        <?php if (isset($m['badge']) && $m['badge'] > 0): ?>
                            <span class="sb-badge"><?= $m['badge'] ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
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

<style>
    .sb-item-group.open .sb-sub-menu { display: block !important; }
    .sb-item-group.open .sb-arrow { transform: rotate(180deg) !important; }
</style>