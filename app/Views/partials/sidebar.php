    <?php
    $uri         = service('uri');
    $currentPage = $uri->getSegment(1) ?: 'dashboard';
    $adminUser   = $admin_user ?? ['nama' => 'Admin', 'role' => '', 'avatar' => 'A'];

    $menu = [
    ['page'=>'dashboard','icon'=>'📊','label'=>'Dashboard',       'badge'=>0],
    ['page'=>'berita',   'icon'=>'📰','label'=>'Berita & Konten', 'badge'=>2],
    ['page'=>'ppdb',     'icon'=>'✏️','label'=>'Data PPDB',       'badge'=>2],
    ['page'=>'agenda',   'icon'=>'📅','label'=>'Agenda & Kegiatan','badge'=>0],
    ['page'=>'galeri',   'icon'=>'🖼️','label'=>'Galeri Foto',     'badge'=>0],
    ['page'=>'guru',     'icon'=>'👨‍🏫','label'=>'Guru & Staf',    'badge'=>0],
    ];
    $menuSistem = [
    ['page'=>'settings','icon'=>'⚙️','label'=>'Pengaturan'],
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
        <a href="<?= base_url($m['page']) ?>"
        class="sb-item <?= $currentPage === $m['page'] ? 'active' : '' ?>">
        <span class="sb-ic"><?= $m['icon'] ?></span>
        <span class="sb-lbl"><?= esc($m['label']) ?></span>
        <?php if ($m['badge'] > 0): ?>
        <span class="sb-badge"><?= $m['badge'] ?></span>
        <?php endif; ?>
        </a>
        <?php endforeach; ?>

        <div class="sb-section">Sistem</div>
        <?php foreach ($menuSistem as $m): ?>
        <a href="<?= base_url($m['page']) ?>"
        class="sb-item <?= $currentPage === $m['page'] ? 'active' : '' ?>">
        <span class="sb-ic"><?= $m['icon'] ?></span>
        <span class="sb-lbl"><?= esc($m['label']) ?></span>
        </a>
        <?php endforeach; ?>

        <a href="<?= esc($web_url ?? 'http://localhost:8080') ?>" target="_blank" class="sb-item">
        <span class="sb-ic">🌐</span>
        <span class="sb-lbl">Lihat Website</span>
        </a>
    </nav>

    <div class="sb-footer">
        <a href="<?= base_url('settings') ?>" class="sb-user">
        <div class="sb-avatar"><?= esc($adminUser['avatar'] ?? 'A') ?></div>
        <div class="sb-user-info">
            <div class="sb-user-name"><?= esc($adminUser['nama'] ?? 'Admin') ?></div>
            <div class="sb-user-role"><?= esc($adminUser['role'] ?? '') ?></div>
        </div>
        </a>
    </div>
    </aside>