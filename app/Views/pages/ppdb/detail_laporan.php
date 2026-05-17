<?php
/**
 * Views: pages/ppdb/detail_laporan.php
 * Detail laporan tahunan PPDB
 */
?>

<div style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
    <a href="<?= base_url('ppdb/laporan') ?>" 
       style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; background:var(--white); color:var(--ink); font-size:13px; font-weight:700; text-decoration:none; border:1.5px solid var(--c4); transition:all .2s;">
       ← Kembali ke Daftar Laporan
    </a>

    <div style="display:flex; gap:10px;">
        <button onclick="window.print()" 
           class="btn" style="background:#FBE9E7; color:#D84315; border:1.5px solid #FFCCBC; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer;">🖨️ Cetak PDF</button>
    </div>
</div>

<!-- Header Laporan -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-header">
        <div class="card-title">📊 Laporan Tahunan PPDB <?= esc($laporan['tahun_ajaran']) ?></div>
    </div>
    <div class="card-body" style="padding:24px;">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:24px;">
            <!-- Status -->
            <div>
                <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Status Laporan</label>
                <?php
                    $statusColor = 'var(--warning)';
                    $statusBg = '#FFF8E1';
                    $statusBorder = '#FFD54F';
                    
                    if ($laporan['status'] === 'Final') {
                        $statusColor = 'var(--success)';
                        $statusBg = '#E8F5E9';
                        $statusBorder = '#81C784';
                    } elseif ($laporan['status'] === 'Arsip') {
                        $statusColor = '#666';
                        $statusBg = '#F5F5F5';
                        $statusBorder = '#BDBDBD';
                    }
                ?>
                <div style="display:inline-block; padding:8px 16px; border-radius:8px; background:<?= $statusBg ?>; color:<?= $statusColor ?>; font-weight:700; border:1.5px solid <?= $statusBorder ?>;">
                    <?= esc($laporan['status']) ?>
                </div>
            </div>

            <!-- Tanggal Dibuat -->
            <div>
                <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Tanggal Dibuat</label>
                <div style="font-weight:600; color:var(--ink);"><?= date('d F Y H:i', strtotime($laporan['created_at'])) ?></div>
            </div>

            <!-- Pembuat Laporan -->
            <div>
                <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Pembuat Laporan</label>
                <div style="font-weight:600; color:var(--ink);"><?= esc($laporan['dibuat_oleh']) ?></div>
            </div>
        </div>

        <?php if (!empty($laporan['catatan'])): ?>
            <div style="margin-top:24px; padding:15px; background:#FFF9E6; border-left:4px solid #FFC107; border-radius:4px;">
                <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Catatan</label>
                <div style="font-size:13px; color:var(--ink); line-height:1.6;">
                    <?= nl2br(esc($laporan['catatan'])) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Ringkasan Statistik -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-header">
        <div class="card-title">📈 Ringkasan Statistik</div>
    </div>
    <div class="card-body" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:16px; padding:24px;">
        
        <div class="ppdb-sum-card" style="background:var(--white); border:1px solid var(--c4); border-radius:12px; padding:15px 20px; text-align:center;">
            <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--c1);"><?= $laporan['total_pendaftar'] ?></div>
            <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Total Pendaftar</div>
        </div>
        
        <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #C8E6C9; border-radius:12px; padding:15px 20px; text-align:center;">
            <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--success);"><?= $laporan['total_diterima'] ?></div>
            <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Diterima</div>
        </div>
        
        <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #FFE082; border-radius:12px; padding:15px 20px; text-align:center;">
            <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--warning);"><?= $laporan['total_menunggu'] ?></div>
            <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Menunggu</div>
        </div>
        
        <div class="ppdb-sum-card" style="background:var(--white); border:1px solid #FFCDD2; border-radius:12px; padding:15px 20px; text-align:center;">
            <div class="psc-num" style="font-size:28px; font-weight:800; color:var(--danger);"><?= $laporan['total_ditolak'] ?></div>
            <div class="psc-lbl" style="font-size:12px; color:var(--gray); font-weight:600;">Ditolak</div>
        </div>

    </div>
</div>

<!-- Detail Lanjutan -->
<div class="card">
    <div class="card-header">
        <div class="card-title">👥 Detail Demografi</div>
    </div>
    <div class="card-body" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:24px; padding:24px;">
        
        <div>
            <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Laki-laki</label>
            <div style="font-size:24px; font-weight:800; color:#1976D2;">👨 <?= $laporan['total_laki_laki'] ?></div>
            <div style="font-size:12px; color:var(--gray); margin-top:4px;">
                <?= round(($laporan['total_laki_laki'] / max($laporan['total_pendaftar'], 1)) * 100, 1) ?>%
            </div>
        </div>

        <div>
            <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Perempuan</label>
            <div style="font-size:24px; font-weight:800; color:#D32F2F;">👩 <?= $laporan['total_perempuan'] ?></div>
            <div style="font-size:12px; color:var(--gray); margin-top:4px;">
                <?= round(($laporan['total_perempuan'] / max($laporan['total_pendaftar'], 1)) * 100, 1) ?>%
            </div>
        </div>

        <div>
            <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:8px; letter-spacing:0.5px;">Rata-rata Usia</label>
            <div style="font-size:24px; font-weight:800; color:#F57C00;">🎂 <?= (int)$laporan['rata_rata_usia'] ?></div>
            <div style="font-size:12px; color:var(--gray); margin-top:4px;">Tahun</div>
        </div>

    </div>
</div>

<style>
    @media print {
        .no-print, a.btn, button { display: none !important; }
        body { background: white; }
        .card { page-break-inside: avoid; }
    }
</style>
