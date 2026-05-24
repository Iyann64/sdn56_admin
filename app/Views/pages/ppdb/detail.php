<!-- Tombol Aksi & Navigasi -->
<div style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
    <a href="<?= base_url('ppdb') ?>" 
       style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; background:var(--white); color:var(--ink); font-size:13px; font-weight:700; text-decoration:none; border:1.5px solid var(--c4); transition:all .2s;">
       ← Kembali ke Daftar
    </a>
    
    <div style="display:flex; gap:10px;">
        <a href="<?= base_url('ppdb/export/'.$item['id_ppdb']) ?>" 
           class="btn" style="background:#E3F2FD; color:#1565C0; border:1px solid #BBDEFB; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:700;">📥 Export Data</a>
           
        <?php if (hasPermission('ppdb', 'edit')): ?>
            <?php if ($item['status'] !== 'Diterima'): ?>
                <a href="<?= base_url('ppdb/status/'.$item['id_ppdb'].'/Diterima') ?>" 
                   class="btn" style="background:var(--success); color:white; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:700;">✅ Terima Siswa</a>
            <?php endif; ?>
            
            <?php if ($item['status'] !== 'Ditolak'): ?>
                <a href="<?= base_url('ppdb/status/'.$item['id_ppdb'].'/Ditolak') ?>" 
                   class="btn" style="background:var(--danger); color:white; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:700;">❌ Tolak</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 380px; gap:24px; align-items: start;">
    
    <!-- KOLOM KIRI: BIODATA -->
    <div style="display:flex; flex-direction:column; gap:24px;">
        
        <!-- Card Identitas Siswa -->
        <div class="card">
            <div class="card-header"><div class="card-title">👤 Identitas Calon Siswa</div></div>
            <div class="card-body" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; padding:24px;">
                <div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px; letter-spacing:0.5px;">Nama Lengkap</label>
                        <div style="font-weight:700; color:var(--ink); font-size:15px;"><?= esc($item['nama']) ?></div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">NIK Siswa</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['nik_siswa'] ?: '-') ?></div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Tempat, Tanggal Lahir</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['tempat_lahir']) ?>, <?= date('d M Y', strtotime($item['tgl_lahir'])) ?></div>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Jenis Kelamin / Agama</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['jenis_kelamin']) ?> / <?= esc($item['agama']) ?></div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Asal Sekolah (TK/PAUD)</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['asal'] ?: '-') ?></div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Usia Saat Mendaftar</label>
                        <div style="font-weight:600; color:var(--ink);"><?= $item['usia'] ?> Tahun</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Orang Tua -->
        <div class="card">
            <div class="card-header"><div class="card-title">👨‍👩‍👧 Data Orang Tua / Wali</div></div>
            <div class="card-body" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; padding:24px;">
                <div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Nama Orang Tua / Hubungan</label>
                        <div style="font-weight:700; color:var(--ink);"><?= esc($item['nama_ortu']) ?> (<?= esc($item['hubungan']) ?>)</div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Pekerjaan / NIK</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['pekerjaan_ortu'] ?: '-') ?> / <?= esc($item['nik_ortu'] ?: '-') ?></div>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Kontak (WA/Email)</label>
                        <div style="font-weight:600; color:var(--ink);"><?= esc($item['telepon']) ?> / <?= esc($item['email']) ?></div>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label style="display:block; font-size:11px; color:var(--gray); text-transform:uppercase; font-weight:800; margin-bottom:4px;">Alamat Domisili</label>
                        <div style="font-weight:600; color:var(--ink); font-size:13px; line-height:1.5;"><?= nl2br(esc($item['alamat'])) ?> <?= $item['kode_pos'] ? ' - '.$item['kode_pos'] : '' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($item['catatan']): ?>
        <div class="card shadow-sm">
            <div class="card-header"><div class="card-title">📝 Catatan Verifikator/Admin</div></div>
            <div class="card-body" style="padding:20px;">
                <div style="font-size:13px; color:var(--ink); line-height:1.6; background:#fffdeb; padding:15px; border-radius:10px; border-left:4px solid var(--warning);">
                    <?= nl2br(esc($item['catatan'])) ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- KOLOM KANAN: STATUS & BERKAS -->
    <div style="display:flex; flex-direction:column; gap:24px;">
        
        <div class="card">
            <div class="card-header"><div class="card-title">📊 Status & Tanggal</div></div>
            <div class="card-body" style="text-align:center; padding:24px;">
                <?php
                $badges = ['Menunggu'=>'badge-warning', 'Diterima'=>'badge-success', 'Ditolak'=>'badge-danger'];
                $cls = $badges[$item['status']] ?? 'badge-secondary';
                ?>
                <span class="badge <?= $cls ?>" style="font-size:16px; padding:10px 24px; border-radius:12px;"><?= $item['status'] ?></span>
                <div style="margin-top:14px; font-size:11px; color:var(--gray); font-weight:600;">Daftar pada: <?= date('d F Y', strtotime($item['tgl_daftar'])) ?></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-title">📂 Berkas Persyaratan</div></div>
            <div class="card-body" style="padding:0;">
                <?php
                $docs = [
                    'file_akta' => 'Akta Kelahiran',
                    'file_kk' => 'Kartu Keluarga',
                    'file_ktp_ortu' => 'KTP Orang Tua',
                    'file_foto_siswa' => 'Pas Foto 3x4',
                    'file_imunisasi' => 'Kartu Imunisasi',
                    'file_surat_sehat' => 'Surat Ket. Sehat',
                    'file_pernyataan' => 'Surat Pernyataan',
                    'file_ijazah_tk' => 'Ijazah TK (Opsional)'
                ];
                
                foreach($docs as $field => $label):
                    $file = $item[$field];
                    $isWajib = $field !== 'file_ijazah_tk';
                ?>
                <div style="padding:16px 20px; border-bottom:1px solid var(--light); display:flex; justify-content:space-between; align-items:center; background:<?= empty($file) && $isWajib ? '#fff5f5' : 'transparent' ?>;">
                    <div>
                        <div style="font-size:12px; font-weight:700; color:var(--ink);"><?= $label ?></div>
                        <div style="font-size:10px; font-weight:600; color:<?= empty($file) ? 'var(--danger)' : 'var(--success)' ?>;">
                            <?= empty($file) ? '❌ Tidak Ada' : '✅ Tersedia' ?>
                        </div>
                    </div>
                    <?php if(!empty($file)): ?>
                        <a href="<?= $web_url . '/uploads/ppdb/' . $file ?>" target="_blank" 
                           style="background:var(--c5); color:var(--c1); width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; text-decoration:none; box-shadow:0 2px 8px rgba(0,0,0,0.05);" 
                           title="Buka Dokumen">
                           👁️
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</div>
