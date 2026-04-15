<!-- ════ STAT CARDS ════ -->
    <div class="stats-row">
    <div class="stat-card">
        <div class="sc-icon sci-c1">👥</div>
        <div class="sc-info">
        <div class="sc-num"><?= number_format($stats['total_siswa'] ?? 512) ?></div>
        <div class="sc-lbl">Total Siswa Aktif</div>
        <div class="sc-change up">↑ Data terkini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="sc-icon sci-c2">👨‍🏫</div>
        <div class="sc-info">
        <div class="sc-num"><?= number_format($stats['total_guru'] ?? 0) ?></div>
        <div class="sc-lbl">Tenaga Pengajar</div>
        <div class="sc-change up">↑ Data terkini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="sc-icon sci-c3">📰</div>
        <div class="sc-info">
        <div class="sc-num"><?= number_format($stats['berita_terbit'] ?? 0) ?></div>
        <div class="sc-lbl">Berita Terbit</div>
        <div class="sc-change up">↑ Data terkini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="sc-icon sci-c4">✏️</div>
        <div class="sc-info">
        <div class="sc-num"><?= number_format($stats['ppdb_pending'] ?? 0) ?></div>
        <div class="sc-lbl">PPDB Menunggu</div>
        <div class="sc-change down">⚠️ Perlu ditinjau</div>
        </div>
    </div>
    </div>

    <!-- ════ ROW 2 ════ -->
    <div class="dash-row2">

    <!-- Aktivitas terbaru -->
    <div class="card">
        <div class="card-header">
        <div class="card-title">🕒 Aktivitas Terbaru</div>
        <a href="<?= base_url('berita') ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0 24px">
        <div class="activity-list">
            <?php if (!empty($berita_terbaru)): foreach ($berita_terbaru as $b): ?>
            <div class="activity-item">
            <div class="act-dot" style="background:var(--success)"></div>
            <div class="act-msg">Berita <strong>"<?= esc($b['judul']) ?>"</strong> · <?= esc($b['status']) ?></div>
            <div class="act-time"><?= date('d M Y', strtotime($b['tanggal'])) ?></div>
            </div>
            <?php endforeach; else: ?>
            <div class="activity-item">
            <div class="act-dot" style="background:var(--gray)"></div>
            <div class="act-msg">Belum ada aktivitas terbaru.</div>
            <div class="act-time">–</div>
            </div>
            <?php endif; ?>

            <?php if (!empty($ppdb_pending)): foreach ($ppdb_pending as $p): ?>
            <div class="activity-item">
            <div class="act-dot" style="background:var(--info)"></div>
            <div class="act-msg">Pendaftar PPDB baru: <strong><?= esc($p['nama']) ?></strong> — menunggu verifikasi</div>
            <div class="act-time"><?= date('d M Y', strtotime($p['tgl_daftar'])) ?></div>
            </div>
            <?php endforeach; endif; ?>
        </div>
        </div>
    </div>

    <!-- Quick actions + chart -->
    <div style="display:flex;flex-direction:column;gap:20px">
        <div class="card">
        <div class="card-header"><div class="card-title">⚡ Aksi Cepat</div></div>
        <div class="card-body">
            <div class="qa-grid">
            <a href="<?= base_url('berita/tambah') ?>" class="qa-item">
                <div class="qa-ic">📝</div><div class="qa-lbl">Tulis Berita</div>
            </a>
            <a href="<?= base_url('ppdb') ?>" class="qa-item">
                <div class="qa-ic">✏️</div><div class="qa-lbl">Cek PPDB</div>
            </a>
            <a href="<?= base_url('galeri') ?>" class="qa-item">
                <div class="qa-ic">🖼️</div><div class="qa-lbl">Upload Foto</div>
            </a>
            <a href="<?= base_url('agenda/tambah') ?>" class="qa-item">
                <div class="qa-ic">📅</div><div class="qa-lbl">Tambah Agenda</div>
            </a>
            </div>
        </div>
        </div>

        <div class="card">
        <div class="card-header"><div class="card-title">📈 Siswa per Kelas</div></div>
        <div class="card-body">
            <div class="chart-bar">
            <?php
            $kelas = $distribusi_kelas ?? ['Kelas 1'=>88,'Kelas 2'=>82,'Kelas 3'=>90,'Kelas 4'=>76,'Kelas 5'=>84,'Kelas 6'=>92];
            $colors = ['var(--c3)','var(--c2)','var(--c1)','var(--gold2)','var(--success)','var(--info)'];
            $max = max($kelas);
            $i = 0;
            foreach ($kelas as $label => $val):
                $pct = round($val / $max * 100);
            ?>
            <div class="cb-item">
                <div class="cb-lbl"><?= esc($label) ?></div>
                <div class="cb-track">
                <div class="cb-fill" style="width:<?= $pct ?>%;background:<?= $colors[$i % 6] ?>"></div>
                </div>
                <div class="cb-val"><?= $val ?></div>
            </div>
            <?php $i++; endforeach; ?>
            </div>
        </div>
        </div>
    </div>

    </div>