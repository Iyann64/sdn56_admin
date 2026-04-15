    <?php
    $berita  = $berita ?? null;
    $isEdit  = $berita !== null;
    $action  = $isEdit ? base_url('berita/update/'.$berita['id']) : base_url('berita/simpan');
    ?>
    <div style="margin-bottom:20px">
    <a href="<?= base_url('berita') ?>" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card" style="max-width:800px">
    <div class="card-header">
        <div class="card-title"><?= $isEdit ? '✏️ Edit Berita' : '📝 Tambah Berita' ?></div>
    </div>
    <div class="card-body">
        <form action="<?= $action ?>" method="POST">
        <?= csrf_field() ?>
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