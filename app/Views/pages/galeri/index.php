    <div class="card">
    <div class="card-header">
        <div class="card-title">🖼️ Galeri Foto</div>
        <?php if (hasPermission('galeri', 'create')): ?>
        <button class="btn btn-primary" onclick="openGaleriModal()">＋ Upload Foto</button>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <!-- Grid galeri -->
        <div class="gallery-mgr" id="galeriGrid">
        <?php
        $bgMap = ['Fasilitas'=>'#006064','Prestasi'=>'#004D40','Kegiatan'=>'#0D47A1',
                    'Lingkungan'=>'#1B5E20','Olahraga'=>'#B71C1C','Seni Budaya'=>'#4A148C'];
        if (empty($list)): ?>
        <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--gray)">
            <div style="font-size:48px;margin-bottom:12px">🖼️</div>
            <div style="font-weight:600">Belum ada foto</div>
            <p style="font-size:13px;margin-top:6px">Upload foto pertama untuk galeri sekolah.</p>
        </div>
        <?php else: foreach ($list as $g):
            $bg  = $bgMap[$g['kategori']] ?? '#006064';
            $src = $g['file_foto'] ? $upload_url . 'galeri/' . $g['file_foto'] : null;
            $ext = $g['file_foto'] ? pathinfo($g['file_foto'], PATHINFO_EXTENSION) : '';
            $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'mov']);
        ?>
        <div class="gm-item" style="<?= (!$isVideo && $src) ? "background:url('$src') center/cover;" : "background:$bg;" ?>">
            <?php if ($isVideo): ?>
                <video src="<?= $src ?>" autoplay muted loop playsinline style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0"></video>
            <?php endif; ?>

            <?php if (!$src && !$isVideo): ?>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:40px">
            <?= esc($g['emoji'] ?? '🖼️') ?>
            </div>
            <?php endif; ?>
            <div class="gm-overlay">
            <div style="flex:1">
                <div style="font-size:12px;font-weight:600;color:white;margin-bottom:3px"><?= esc($g['nama']) ?></div>
                <div style="font-size:10px;color:rgba(255,255,255,.7)"><?= esc($g['kategori']) ?></div>
            </div>
            <div class="gm-actions">
            <?php if (hasPermission('galeri', 'edit')): ?>
            <button class="gm-btn edit"
                onclick='openGaleriModal(
<?= (int)$g['id'] ?>,
<?= json_encode($g['nama']) ?>,
<?= json_encode($g['kategori']) ?>,
<?= json_encode($g['emoji']) ?>
)'
                title="Edit">
                ✏️
            </button>
            <?php endif; ?>
            <?php if (hasPermission('galeri', 'delete')): ?>
            <a href="<?= base_url('galeri/hapus/'.$g['id']) ?>" class="gm-btn delete"
                onclick="return confirm('Hapus foto ini?')">
                🗑️
            </a>
            <?php endif; ?>
            </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
        </div>

    </div>
    </div>

    <!-- Modal Galeri -->
    <div class="modal-overlay" id="modalGaleri">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalGaleriTitle" class="modal-title">Upload Foto</h3>
                <button class="modal-close" onclick="closeModal('modalGaleri')">✕</button>
            </div>
            <div class="modal-body">
                <form id="formGaleri" 
                    method="POST" 
                    enctype="multipart/form-data"
                    data-upload="<?= base_url('galeri/upload') ?>"
                    data-update="<?= base_url('galeri/update') ?>">
                    
                    <?= csrf_field() ?>
                    <input type="file" id="gFoto" name="foto" accept="image/*,video/*" style="display:none">
                    
                    <div id="uploadZone" class="upload-zone" onclick="document.getElementById('gFoto').click()">
                        <div style="font-size:40px;margin-bottom:8px">📁</div>
                        <div style="font-size:14px;font-weight:600;color:var(--c1)">Klik untuk pilih foto atau video</div>
                        <div style="font-size:12px;color:var(--gray);margin-top:4px">PNG, JPG, WEBP, MP4 — maks. 50MB</div>
                        <div id="fileName" style="font-size:12px;color:var(--green);margin-top:8px;font-weight:600"></div>
                    </div>

                    <div class="fg">
                        <label>Nama / Keterangan Foto *</label>
                        <input type="text" id="gNama" name="nama" placeholder="Deskripsi singkat foto..." required>
                    </div>

                    <div class="form-grid-2">
                        <div class="fg">
                            <label>Kategori</label>
                            <select id="gKategori" name="kategori">
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Prestasi">Prestasi</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Lingkungan">Lingkungan</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Seni Budaya">Seni Budaya</option>
                            </select>
                        </div>
                        <div class="fg">
                            <label>Emoji / Ikon</label>
                            <input type="text" id="gEmoji" name="emoji" placeholder="🖼️" maxlength="4">
                        </div>
                    </div>

                    <div class="modal-footer" style="margin-top:20px; padding:0">
                        <button type="button" class="btn btn-gray" onclick="closeModal('modalGaleri')">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>