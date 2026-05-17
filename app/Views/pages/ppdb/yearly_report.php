<?php
$currentYear = $year ?? date('Y');
$summary = $summary ?? [];
$list = $list ?? [];
$availableYears = $available_years ?? [];
?>

<div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;" class="no-print">
    <a href="<?= base_url('ppdb') ?>"
       style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; background:var(--white); color:var(--ink); font-size:13px; font-weight:700; text-decoration:none; border:1.5px solid var(--c4); transition:all .2s;">
       ← Kembali ke Daftar PPDB
    </a>

    <div style="display:flex; gap:10px; align-items:center;">
        <label for="year-filter" style="font-size:13px; font-weight:700; color:var(--ink);">Filter Tahun:</label>
        <select id="year-filter" onchange="window.location.href='<?= base_url('ppdb/report') ?>/' + this.value"
                style="padding:8px 12px; border-radius:8px; border:1px solid var(--c4); background:white; font-size:13px; font-weight:600;">
            <?php foreach ($availableYears as $y): ?>
                <option value="<?= $y ?>" <?= ($y == $currentYear) ? 'selected' : '' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>

        <a href="<?= base_url('ppdb/export/0/' . $currentYear) ?>"
           class="btn" style="background:#E3F2FD; color:#1565C0; border:1px solid #BBDEFB; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:700;">📥 Export Excel</a>

        <button onclick="window.print()" 
           class="btn" style="background:#FBE9E7; color:#D84315; border:1.5px solid #FFCCBC; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer;">🖨️ Cetak PDF</button>
    </div>
</div>

<!-- Summary Cards -->
<div class="ppdb-summary" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="ppdb-sum-card" style="background:var(--white); border:1px solid var(--c4); border-radius:12px; padding:15px 20px; text-align:center;">
        <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--c1);"><?= $summary['total'] ?? 0 ?></div>
        <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Total Pendaftar</div>
    </div>
    <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #C8E6C9; border-radius:12px; padding:15px 20px; text-align:center;">
        <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--success);"><?= $summary['Diterima'] ?? 0 ?></div>
        <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Diterima</div>
    </div>
    <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #FFE082; border-radius:12px; padding:15px 20px; text-align:center;">
        <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--warning);"><?= $summary['Menunggu'] ?? 0 ?></div>
        <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Menunggu</div>
    </div>
    <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #FFCDD2; border-radius:12px; padding:15px 20px; text-align:center;">
        <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--danger);"><?= $summary['Ditolak'] ?? 0 ?></div>
        <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Ditolak</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
    <!-- Gender Distribution -->
    <div class="card">
        <div class="card-header"><div class="card-title">🚻 Distribusi Jenis Kelamin</div></div>
        <div class="card-body" style="display:flex; justify-content:space-around; text-align:center; padding:20px;">
            <div>
                <div style="font-size:24px; font-weight:800; color:var(--c1);"><?= $summary['laki_laki'] ?? 0 ?></div>
                <div style="font-size:12px; color:var(--gray);">Laki-laki</div>
            </div>
            <div style="width:1px; background:var(--light);"></div>
            <div>
                <div style="font-size:24px; font-weight:800; color:var(--c3);"><?= $summary['perempuan'] ?? 0 ?></div>
                <div style="font-size:12px; color:var(--gray);">Perempuan</div>
            </div>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="card">
        <div class="card-header"><div class="card-title">📈 Tren Pendaftaran Per Bulan</div></div>
        <div class="card-body" style="padding:15px; display:flex; gap:5px; align-items:flex-end; height:80px;">
            <?php 
            $max = max($summary['monthly'] ?: [1]);
            foreach ($summary['monthly'] as $m => $count): 
                $height = ($count / $max) * 100;
            ?>
                <div style="flex:1; background:var(--c5); height:<?= max($height, 5) ?>%; border-radius:3px; position:relative;" title="Bulan <?= $m ?>: <?= $count ?>">
                    <?php if($count > 0): ?>
                        <span style="position:absolute; top:-15px; width:100%; text-align:center; font-size:9px; font-weight:700;"><?= $count ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="display:flex; padding:0 15px 10px; font-size:9px; color:var(--gray); justify-content:space-between;">
            <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
            <span>Jul</span><span>Agu</span><span>Sep</span><span>Okt</span><span>Nov</span><span>Des</span>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Daftar Pendaftar Tahun <?= $currentYear ?></div>
    </div>
    <div class="card-body" style="padding:0">
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>Jalur & Asal</th>
                    <th>Tgl Daftar</th>
                    <th>Status</th>
                    <th class="no-print">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($list)): ?>
                <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--gray)">📭 Tidak ada data untuk tahun ini.</td></tr>
                <?php else: foreach ($list as $i => $p): ?>
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--ink)"><?= esc($p['nama']) ?></div>
                        <div style="font-size:11px;color:var(--gray)">NIK: <?= esc($p['nik_siswa']) ?></div>
                    </td>
                    <td><?= $p['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></td>
                    <td>
                        <div style="font-weight:600;font-size:12px;color:var(--c1)"><?= esc($p['jalur_pendaftaran'] ?? '-') ?></div>
                        <div style="font-size:11px;color:var(--gray)"><?= esc($p['asal'] ?? '-') ?></div>
                    </td>
                    <td><?= date('d M Y', strtotime($p['tgl_daftar'])) ?></td>
                    <td>
                        <?php
                        $badges = ['Menunggu'=>'badge-warning', 'Diterima'=>'badge-success', 'Ditolak'=>'badge-danger'];
                        $cls = $badges[$p['status']] ?? 'badge-secondary';
                        ?>
                        <span class="badge <?= $cls ?>"><?= esc($p['status']) ?></span>
                    </td>
                    <td class="no-print">
                        <div style="display:flex;gap:4px;">
                            <a href="<?= base_url('ppdb/detail/'.$p['id']) ?>" class="btn btn-sm" style="background:var(--c5);color:var(--c1)">👁️</a>
                            <a href="<?= base_url('ppdb/export/'.$p['id']) ?>" class="btn btn-sm" style="background:#E3F2FD;color:#1565C0">📥</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .ppdb-sum-card {
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        transition: transform .2s;
    }
    .ppdb-sum-card:hover {
        transform: translateY(-3px);
    }
    .card-header {
        padding: 15px 20px;
        border-bottom: 1px solid var(--light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title {
        font-weight: 800;
        color: var(--ink);
        font-size: 14px;
    }

    @media print {
        /* Sembunyikan elemen UI yang tidak perlu */
        .sidebar, .topbar, .sb-nav, .sb-head, .sb-footer, .no-print, #mobileHam, .tb-right, .tb-breadcrumb {
            display: none !important;
        }
        
        /* Sesuaikan tata letak utama */
        .main-area { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
        .page-content { padding: 0 !important; }
        .admin-layout { display: block !important; }
        
        body { background: white !important; font-size: 12px; color: #000; }
        
        /* Rapikan card dan tabel */
        .card { border: 1px solid #eee !important; box-shadow: none !important; margin-bottom: 20px !important; break-inside: avoid; }
        .card-header { padding: 10px 15px !important; background: #f9f9f9 !important; }
        
        .ppdb-summary { gap: 10px !important; margin-bottom: 15px !important; display: flex !important; }
        .ppdb-sum-card { flex: 1; padding: 10px !important; border: 1px solid #eee !important; }
        .psc-num { font-size: 20px !important; }

        table { width: 100% !important; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #eee !important; padding: 8px !important; text-align: left; }
        
        /* Atur margin halaman */
        @page {
            margin: 1.5cm;
        }
    }
</style>