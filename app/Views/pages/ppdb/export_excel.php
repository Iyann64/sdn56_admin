<style>
    .header { background-color: #1a237e; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000; }
    .text { mso-number-format: "\@"; } /* Memaksa NIK/NISN agar tidak berubah jadi scientific notation */
    .center { text-align: center; border: 1px solid #000000; }
    .title { font-size: 18px; font-weight: bold; text-align: center; padding: 10px; }
    td { border: 1px solid #000000; padding: 5px; }
</style>

<table border="1">
    <tr>
        <td colspan="25" class="title">DATA PENDAFTARAN SISWA BARU (PPDB) SDN 56 PRABUMULIH</td>
    </tr>
    <tr>
        <td colspan="25" class="center" style="border:none;">Laporan Tahun: <?= $year ?? 'Semua' ?> | Tanggal Ekspor: <?= date('d/m/Y H:i') ?></td>
    </tr>
    <tr></tr> <!-- Baris Kosong -->
    <thead>
        <tr class="header">
            <th>No.</th>
            <th>Nama Lengkap</th>
            <th>NIK Siswa</th>
            <th>NISN</th>
            <th>L/P</th>
            <th>Agama</th>
            <th>Tempat Lahir</th>
            <th>Tgl Lahir</th>
            <th>Usia</th>
            <th>Nama Ortu</th>
            <th>Telepon/WA</th>
            <th>Email</th>
            <th>Alamat Lengkap</th>
            <th>Asal Sekolah</th>
            <th>Jalur Pendaftaran</th>
            <th>Status</th>
            <th>Tgl Daftar</th>
            <th>Link Akta</th>
            <th>Link KK</th>
            <th>Link KTP</th>
            <th>Link Foto</th>
            <th>Link Imunisasi</th>
            <th>Link Sehat</th>
            <th>Link Ijazah</th>
            <th>Link Pernyataan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td class="center"><?= $row['id_ppdb'] ?></td>
            <td><?= esc($row['nama']) ?></td>
            <td class="text"><?= esc($row['nik_siswa']) ?></td>
            <td class="text"><?= esc($row['nisn'] ?: '-') ?></td>
            <td class="center"><?= $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></td>
            <td><?= esc($row['agama']) ?></td>
            <td><?= esc($row['tempat_lahir']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['tgl_lahir'])) ?></td>
            <td class="center"><?= $row['usia'] ?></td>
            <td><?= esc($row['nama_ortu']) ?></td>
            <td class="text"><?= esc($row['telepon']) ?></td>
            <td><?= esc($row['email']) ?></td>
            <td><?= esc($row['alamat']) ?></td>
            <td><?= esc($row['asal']) ?></td>
            <td><?= esc($row['jalur_pendaftaran']) ?></td>
            <td class="center"><?= strtoupper($row['status']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['tgl_daftar'])) ?></td>
            
            <!-- Link Dokumen -->
            <?php 
            $docs = ['file_akta', 'file_kk', 'file_ktp_ortu', 'file_foto_siswa', 'file_imunisasi', 'file_surat_sehat', 'file_ijazah_tk', 'file_pernyataan'];
            foreach ($docs as $doc): 
                if (!empty($row[$doc])): 
                    $fileUrl = base_url('ppdb/serveFile/' . trim((string)$row[$doc]));
                    $ext = pathinfo($row[$doc], PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp', 'gif'])): ?>
                        <td style="text-align:center; vertical-align:middle;"><img src="<?= $fileUrl ?>" width="60" height="80"></td>
                    <?php else: ?>
                        <td><a href="<?= $fileUrl ?>">Lihat File</a></td>
                    <?php endif; ?>
                <?php else: ?>
                    <td style="color: #ff0000;">Kosong</td>
                <?php endif; 
            endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
