    <?php
    $berita  = $berita ?? null;
    $isEdit  = $berita !== null;
    $action  = $isEdit ? base_url('berita/update/'.$berita['id_berita']) : base_url('berita/simpan');
    ?>
    <div style="margin-bottom:20px">
    <a href="<?= base_url('berita') ?>" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card" style="max-width:800px">
    <div class="card-header">
        <div class="card-title"><?= $isEdit ? '✏️ Edit Berita' : '📝 Tambah Berita' ?></div>
    </div>
    <div class="card-body">
        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="fg">
            <label>Thumbnail / Video Berita</label>
            <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*,video/*" style="margin-bottom: 5px;">
            <div id="mediaPreview" style="margin-top: 10px; display: <?= $isEdit && $berita['thumbnail'] ? 'block' : 'none' ?>; text-align: center; background: #f8f9fa; padding: 10px; border-radius: 10px; border: 1px dashed var(--c4);">
                <?php if ($isEdit && $berita['thumbnail']): ?>
                    <?php 
                        $ext = pathinfo($berita['thumbnail'], PATHINFO_EXTENSION);
                        $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'mov']);
                        $fileUrl = $upload_url . 'berita/' . $berita['thumbnail'];
                    ?>
                    <?php if ($isVideo): ?>
                        <video src="<?= $fileUrl ?>" controls style="max-width:100%; max-height:200px; border-radius:8px; display:block; margin:0 auto;"></video>
                    <?php else: ?>
                        <img src="<?= $fileUrl ?>" style="max-width:100%; max-height:200px; border-radius:8px; display:block; margin:0 auto;">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <small style="display:block; color:var(--gray); font-size:11px;">Format: JPG, PNG, WEBP, MP4. Maks 50MB. Biarkan kosong jika tidak ingin mengubah.</small>
        </div>
        <div class="fg"><label>Judul Berita *</label>
            <input type="text" name="judul" placeholder="Judul berita..."
                value="<?= old('judul', $berita['judul'] ?? '') ?>" required>
        </div>
        <div class="form-grid-2">
            <div class="fg">
            <label>Kategori</label>
            <select name="kategori">
                <?php foreach (['Prestasi','Kegiatan','Akademik','Lingkungan','Seni Budaya','Olahraga'] as $k): ?>
                <option <?= old('kategori', $berita['kategori'] ?? '') === $k ? 'selected' : '' ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="fg">
            <label>Status</label>
            <select name="status">
                <option <?= old('status', $berita['status'] ?? '') === 'Terbit' ? 'selected' : '' ?>>Terbit</option>
                <option <?= old('status', $berita['status'] ?? '') === 'Draf'   ? 'selected' : '' ?>>Draf</option>
            </select>
            </div>
        </div>
        <div class="fg"><label>Tanggal *</label>
            <input type="date" name="tanggal"
                value="<?= old('tanggal', $berita['tanggal'] ?? date('Y-m-d')) ?>" required>
        </div>
        <div class="fg"><label>Isi Berita</label>
            <textarea name="isi" placeholder="Tulis isi berita di sini..." style="height:200px"><?= old('isi', $berita['isi'] ?? '') ?></textarea>
        </div>
        <div style="display:flex;gap:12px;margin-top:8px">
            <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Update' : 'Simpan' ?></button>
            <a href="<?= base_url('berita') ?>" class="btn btn-outline">Batal</a>
        </div>
        </form>
    </div>
    </div>

    <script>
    document.getElementById('thumbnailInput').addEventListener('change', function() {
        const preview = document.getElementById('mediaPreview');
        preview.innerHTML = '';
        preview.style.display = 'none';
        
        const file = this.files[0];
        if (file) {
            preview.style.display = 'block';
            const url = URL.createObjectURL(file);
            if (file.type.startsWith('image/')) {
                preview.innerHTML = `<img src="${url}" style="max-width:100%; max-height:200px; border-radius:8px; display:block; margin:0 auto;">`;
            } else if (file.type.startsWith('video/')) {
                preview.innerHTML = `<video src="${url}" controls style="max-width:100%; max-height:200px; border-radius:8px; display:block; margin:0 auto;"></video>`;
            }
        }
    });
    </script>
