<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PPDB Tahun <?= $year ?></title>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #1e3448; margin: 0; padding: 20px; font-size: 11px; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #006064; padding-bottom: 10px; margin-bottom: 20px; position: relative; }
        .logo { width: 60px; position: absolute; left: 0; top: 0; }
        h1 { margin: 0; font-size: 18px; text-transform: uppercase; color: #006064; }
        .subtitle { font-size: 14px; font-weight: bold; margin-top: 5px; }
        
        .summary-box { display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px; }
        .stat-card { flex: 1; border: 1px solid #eee; padding: 10px; text-align: center; border-radius: 8px; }
        .stat-val { font-size: 16px; font-weight: 800; color: #006064; }
        .stat-label { font-size: 9px; color: #5c7a8a; text-transform: uppercase; margin-top: 2px; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f0f7f8; color: #006064; font-weight: 800; text-align: left; border: 1px solid #d1e4e6; padding: 8px; }
        td { border: 1px solid #eee; padding: 6px 8px; vertical-align: top; }
        .text-center { text-align: center; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .badge-success { background: #e8f5e9; color: #2e7d32; }
        .badge-warning { background: #fff8e1; color: #f57f17; }
        .badge-danger { background: #ffebee; color: #c62828; }

        .footer { margin-top: 30px; text-align: right; }
        
        @media print {
            @page { margin: 1.5cm; size: A4; }
            .no-print { display: none; }
            body { padding: 0; }
            .header { border-bottom-color: #000; }
            th { background: #f5f5f5 !important; color: #000 !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <img src="<?= $logo_url ?>" class="logo" alt="Logo">
        <h1>SD Negeri 56 Prabumulih</h1>
        <div class="subtitle">Laporan Penerimaan Peserta Didik Baru (PPDB)</div>
        <div style="font-size: 12px;">Tahun Ajaran <?= $year ?> / <?= $year + 1 ?></div>
    </div>

    <div class="summary-box">
        <div class="stat-card">
            <div class="stat-val"><?= $summary['total'] ?></div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-val"><?= $summary['Diterima'] ?></div>
            <div class="stat-label">Diterima</div>
        </div>
        <div class="stat-card">
            <div class="stat-val"><?= $summary['Menunggu'] ?></div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-card">
            <div class="stat-val"><?= $summary['Ditolak'] ?></div>
            <div class="stat-label">Ditolak</div>
        </div>
        <div class="stat-card">
            <div class="stat-val"><?= $summary['laki_laki'] ?>L / <?= $summary['perempuan'] ?>P</div>
            <div class="stat-label">Gender (L/P)</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30" class="text-center">No.</th>
                <th>Nama Lengkap</th>
                <th width="40" class="text-center">L/P</th>
                <th>Asal Sekolah</th>
                <th width="80" class="text-center">Tgl Daftar</th>
                <th width="80" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list)): ?>
                <tr><td colspan="6" class="text-center">Tidak ada data pendaftar.</td></tr>
            <?php else: foreach ($list as $p): ?>
                <tr>
                    <td class="text-center"><?= esc($p['id_ppdb']) ?></td>
                    <td>
                        <strong><?= esc($p['nama']) ?></strong><br>
                        <span style="font-size: 9px; color: #666;">NIK: <?= esc($p['nik_siswa']) ?></span>
                    </td>
                    <td class="text-center"><?= $p['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></td>
                    <td><?= esc($p['asal'] ?: '-') ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tgl_daftar'])) ?></td>
                    <td class="text-center">
                        <?php
                        $cls = 'badge-warning';
                        if($p['status'] == 'Diterima') $cls = 'badge-success';
                        if($p['status'] == 'Ditolak') $cls = 'badge-danger';
                        ?>
                        <span class="badge <?= $cls ?>"><?= $p['status'] ?></span>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Prabumulih, <?= date('d F Y') ?><br>
        Mengetahui,<br>
        Kepala Sekolah SDN 56 Prabumulih<br>
        <br><br><br>
        ( ............................................ )
    </div>
</body>
</html>
