    <!-- Summary Cards -->
    <div class="ppdb-summary">
    <div class="ppdb-sum-card" style="border-color:var(--c4)">
        <div class="psc-num" style="color:var(--c1)"><?= $summary['total'] ?? 0 ?></div>
        <div class="psc-lbl">Total Pendaftar</div>
    </div>
    <div class="ppdb-sum-card" style="border-color:#C8E6C9">
        <div class="psc-num" style="color:var(--success)"><?= $summary['diterima'] ?? 0 ?></div>
        <div class="psc-lbl">Diterima</div>
    </div>
    <div class="ppdb-sum-card" style="border-color:#FFE082">
        <div class="psc-num" style="color:var(--warning)"><?= $summary['menunggu'] ?? 0 ?></div>
        <div class="psc-lbl">Menunggu</div>
    </div>
    <div class="ppdb-sum-card" style="border-color:#FFCDD2">
        <div class="psc-num" style="color:var(--danger)"><?= $summary['ditolak'] ?? 0 ?></div>
        <div class="psc-lbl">Ditolak</div>
    </div>
    </div>

    <div class="card">
    <div class="card-header">
        <div class="card-title">✏️ Data Pendaftar PPDB</div>
        <div style="display:flex;gap:10px">
            <a href="<?= base_url('ppdb/export') ?>" class="btn btn-outline" style="background:#E3F2FD;color:#1565C0;border-color:#BBDEFB">📥 Export Excel</a>
            <?php if (hasPermission('ppdb', 'create')): ?>
            <a href="<?= base_url('ppdb/tambah') ?>" class="btn btn-primary">＋ Tambah Pendaftar</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body" style="padding:0">
        <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Nama Lengkap</th><th>Tgl Daftar</th><th>Asal Sekolah</th>
                <th>Usia</th><th>Dokumen</th><th>Status</th><th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($list)): ?>
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--gray)">📭 Belum ada pendaftar</td></tr>
            <?php else: foreach ($list as $p): ?>
            <tr>
                <td><div style="font-weight:600;color:var(--ink)"><?= esc($p['nama']) ?></div>
                    <div style="font-size:11px;color:var(--gray)"><?= esc($p['email'] ?? '') ?></div></td>
                <td><?= date('d M Y', strtotime($p['tgl_daftar'])) ?></td>
                <td><?= esc($p['asal'] ?? '-') ?></td>
                <td><?= $p['usia'] ?? '-' ?> tahun</td>
                <td>
                    <?php
                    $docs = ['file_akta', 'file_kk', 'file_ktp_ortu', 'file_foto_siswa', 'file_imunisasi', 'file_surat_sehat', 'file_pernyataan'];
                    $count = 0;
                    foreach($docs as $d) if(!empty($p[$d])) $count++;
                    $color = $count >= 7 ? 'var(--success)' : 'var(--warning)';
                    ?>
                    <div style="font-size:11px; font-weight:700; color:<?= $color ?>">
                        📂 <?= $count ?> / 7 Wajib
                    </div>
                    <?php if(!empty($p['file_ijazah_tk'])): ?>
                        <div style="font-size:9px; color:var(--c1)">+ Ijazah TK</div>
                    <?php endif; ?>
                </td>
                <td>
                <?php
                $bc = ['Diterima'=>'badge-success','Menunggu'=>'badge-warning','Ditolak'=>'badge-danger'];
                $cls = $bc[$p['status']] ?? 'badge-secondary';
                ?>
                <span class="badge <?= $cls ?>"><?= esc($p['status']) ?></span>
                </td>
                <td>
                <div style="display:flex;gap:4px;flex-wrap:wrap">
                    <a href="<?= base_url('ppdb/detail/'.$p['id']) ?>" class="btn btn-sm" style="background:var(--c5);color:var(--c1)" title="Cek Kelengkapan">👁️</a>
                    <?php if (hasPermission('ppdb', 'edit')): ?>
                    <a href="<?= base_url('ppdb/status/'.$p['id'].'/Diterima') ?>" class="btn btn-sm" style="background:#E8F5E9;color:#2E7D32">✅</a>
                    <a href="<?= base_url('ppdb/status/'.$p['id'].'/Ditolak') ?>"  class="btn btn-sm" style="background:#FFEBEE;color:#C62828">❌</a>
                    <?php endif; ?>
                    <?php if (hasPermission('ppdb', 'delete')): ?>
                    <a href="<?= base_url('ppdb/hapus/'.$p['id']) ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus data ini?')">🗑️</a>
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>