<?php
/**
 * Views: pages/ppdb/daftar_laporan.php
 * Daftar laporan tahunan PPDB
 */
?>

<div style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
    <a href="<?= canAccess('ppdb') ? base_url('ppdb') : base_url('ppdb/report') ?>" 
       style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; background:var(--white); color:var(--ink); font-size:13px; font-weight:700; text-decoration:none; border:1.5px solid var(--c4); transition:all .2s;">
       ← Kembali ke PPDB
    </a>

    <?php if (hasPermission('ppdb_laporan', 'create')): ?>
    <div style="display:flex; gap:12px; align-items:center;">
        <form method="POST" action="<?= base_url('ppdb/simpan-laporan') ?>" style="display:flex; gap:12px; align-items:center;">
            <?= csrf_field() ?>
            
            <select name="tahun" style="padding:10px 15px; border-radius:8px; border:1px solid var(--c4); background:white; font-size:13px; font-weight:600;" required>
                <option value="">Pilih tahun laporan...</option>
                <?php 
                $ppdbModel = new \App\Models\PpdbModel();
                $years = $ppdbModel->getAvailableYears();
                foreach ($years as $year): 
                ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                <?php endforeach; ?>
            </select>
            
            <input type="text" name="catatan" placeholder="Catatan laporan (opsional)" 
                style="padding:10px 15px; border-radius:8px; border:1px solid var(--c4); background:white; font-size:13px; flex:1; max-width:250px;" />
            
            <button type="submit" class="btn" style="background:var(--success); color:white; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; border:none; white-space:nowrap;">
                ➕ Generate Laporan
            </button>
        </form>
    </div>
    <?php endif; ?>
</div>
<!-- Alert Messages -->
<?php if (session()->has('success')): ?>
    <div style="padding:15px 20px; border-radius:10px; background:#E8F5E9; border:1px solid #81C784; color:#2E7D32; margin-bottom:20px; font-size:13px; font-weight:600;">
        ✅ <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('warning')): ?>
    <div style="padding:15px 20px; border-radius:10px; background:#FFF8E1; border:1px solid #FFD54F; color:#F57F17; margin-bottom:20px; font-size:13px; font-weight:600;">
        ⚠️ <?= session('warning') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div style="padding:15px 20px; border-radius:10px; background:#FFEBEE; border:1px solid #EF5350; color:#C62828; margin-bottom:20px; font-size:13px; font-weight:600;">
        ❌ <?= session('error') ?>
    </div>
<?php endif; ?>

<!-- Table Laporan Tahunan -->
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Daftar Laporan Tahunan PPDB</div>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <?php if (!empty($laporan)): ?>
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:var(--c1); color:white; text-align:left;">
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Tahun Ajaran</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Total Pendaftar</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Diterima</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Menunggu</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Ditolak</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Status</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Pembuat</th>
                        <th style="padding:15px; border-bottom:2px solid var(--c4);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $l): ?>
                        <tr style="border-bottom:1px solid var(--c4);">
                            <td style="padding:15px; font-weight:600;"><?= esc($l['tahun_ajaran']) ?></td>
                            <td style="padding:15px; text-align:center; font-weight:700; color:var(--c1);">
                                <?= $l['total_pendaftar'] ?>
                            </td>
                            <td style="padding:15px; text-align:center; color:var(--success); font-weight:600;">
                                ✅ <?= $l['total_diterima'] ?>
                            </td>
                            <td style="padding:15px; text-align:center; color:var(--warning); font-weight:600;">
                                ⏳ <?= $l['total_menunggu'] ?>
                            </td>
                            <td style="padding:15px; text-align:center; color:var(--danger); font-weight:600;">
                                ❌ <?= $l['total_ditolak'] ?>
                            </td>
                            <td style="padding:15px;">
                                <?php
                                    $statusColor = 'var(--warning)';
                                    $statusBg = '#FFF8E1';
                                    $statusBorder = '#FFD54F';
                                    
                                    if ($l['status'] === 'Final') {
                                        $statusColor = 'var(--success)';
                                        $statusBg = '#E8F5E9';
                                        $statusBorder = '#81C784';
                                    } elseif ($l['status'] === 'Arsip') {
                                        $statusColor = '#666';
                                        $statusBg = '#F5F5F5';
                                        $statusBorder = '#BDBDBD';
                                    }
                                ?>
                                <div style="display:inline-block; padding:6px 12px; border-radius:6px; background:<?= $statusBg ?>; color:<?= $statusColor ?>; font-weight:700; font-size:12px; border:1px solid <?= $statusBorder ?>;">
                                    <?= esc($l['status']) ?>
                                </div>
                            </td>
                            <td style="padding:15px; font-size:12px; color:var(--gray);">
                                <?= esc($l['dibuat_oleh']) ?><br>
                                <small><?= date('d M Y', strtotime($l['created_at'])) ?></small>
                            </td>
                            <td style="padding:15px;">
                                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                    <a href="<?= base_url('ppdb/detail-laporan/'.$l['id_ppdb_laporan_tahunan']) ?>" 
                                       class="btn" style="padding:6px 12px; border-radius:6px; background:#E3F2FD; color:#1565C0; text-decoration:none; font-size:12px; font-weight:600; border:1px solid #BBDEFB;">
                                       👁️ Lihat
                                    </a>
                                    
                                    <?php if ($l['status'] === 'Draft' && hasPermission('ppdb_laporan', 'edit')): ?>
                                        <a href="<?= base_url('ppdb/finalisasi-laporan/'.$l['id_ppdb_laporan_tahunan']) ?>" 
                                           class="btn" style="padding:6px 12px; border-radius:6px; background:#E8F5E9; color:#2E7D32; text-decoration:none; font-size:12px; font-weight:600; border:1px solid #81C784;"
                                           onclick="return confirm('Finalisasi laporan ini? Tidak bisa diubah lagi.');">
                                           ✅ Finalisasi
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($l['status'] === 'Final' && hasPermission('ppdb_laporan', 'delete')): ?>
                                        <a href="<?= base_url('ppdb/arsipkan-laporan/'.$l['id_ppdb_laporan_tahunan']) ?>" 
                                           class="btn" style="padding:6px 12px; border-radius:6px; background:#FBE9E7; color:#D84315; text-decoration:none; font-size:12px; font-weight:600; border:1px solid #FFCCBC;"
                                           onclick="return confirm('Arsipkan laporan ini?');">
                                           📦 Arsip
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align:center; padding:40px 20px; color:var(--gray);">
                <div style="font-size:48px; margin-bottom:10px;">📭</div>
                <p style="font-size:14px; font-weight:600;">Belum ada laporan tahunan</p>
                <p style="font-size:12px;">Silakan generate laporan baru untuk tahun yang diinginkan</p>
            </div>
        <?php endif; ?>
    </div>
</div>
