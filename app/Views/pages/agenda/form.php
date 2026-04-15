    <?php
    $item   = $item ?? null;
    $isEdit = $item !== null;
    $action = $isEdit ? base_url('agenda/update/'.$item['id']) : base_url('agenda/simpan');
    ?>
    <div style="margin-bottom:20px">
    <a href="<?= base_url('agenda') ?>" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card" style="max-width:640px">
    <div class="card-header">
        <div class="card-title"><?= $isEdit ? '✏️ Edit Agenda' : '📅 Tambah Agenda' ?></div>
    </div>
    <div class="card-body">
        <form action="<?= $action ?>" method="POST">
        <?= csrf_field() ?>
        <div class="fg"><label>Judul Kegiatan *</label>
            <input type="text" name="judul" placeholder="Nama kegiatan..."
                value="<?= old('judul', $item['judul'] ?? '') ?>" required>
        </div>
        <div class="form-grid-2">
            <div class="fg"><label>Tanggal *</label>
            <input type="date" name="tanggal" value="<?= old('tanggal', $item['tanggal'] ?? '') ?>" required>
            </div>
            <div class="fg"><label>Waktu</label>
            <input type="time" name="waktu" value="<?= old('waktu', $item['waktu'] ?? '08:00') ?>">
            </div>
        </div>
        <div class="fg"><label>Tempat</label>
            <input type="text" name="tempat" placeholder="Lokasi kegiatan..."
                value="<?= old('tempat', $item['tempat'] ?? '') ?>">
        </div>
        <div class="form-grid-2">
            <div class="fg">
            <label>Kategori</label>
            <select name="kategori">
                <?php foreach (['Akademik','Rapat','Upacara','PPDB','Ekskul','Keagamaan','Lainnya'] as $k): ?>
                <option <?= old('kategori', $item['kategori'] ?? '') === $k ? 'selected':'' ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="fg">
            <label>Status</label>
            <select name="status">
                <?php foreach (['Aktif','Selesai','Batal'] as $s): ?>
                <option <?= old('status', $item['status'] ?? 'Aktif') === $s ? 'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div style="display:flex;gap:12px;margin-top:8px">
            <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Update' : 'Simpan' ?></button>
            <a href="<?= base_url('agenda') ?>" class="btn btn-outline">Batal</a>
        </div>
        </form>
    </div>
    </div>