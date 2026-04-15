    <?php
    $item   = $item ?? null;
    $isEdit = $item !== null;
    $action = $isEdit ? base_url('guru/update/'.$item['id']) : base_url('guru/simpan');
    ?>
    <div style="margin-bottom:20px">
    <a href="<?= base_url('guru') ?>" class="btn btn-outline">← Kembali</a>
    </div>
    <div class="card" style="max-width:640px">
    <div class="card-header">
        <div class="card-title"><?= $isEdit ? '✏️ Edit Data Guru' : '👨‍🏫 Tambah Guru' ?></div>
    </div>
    <div class="card-body">
        <form action="<?= $action ?>" method="POST">
        <?= csrf_field() ?>
        <div class="fg"><label>Nama Lengkap & Gelar *</label>
            <input type="text" name="nama" placeholder="cth: Budi Santoso, S.Pd"
                value="<?= old('nama', $item['nama'] ?? '') ?>" required>
        </div>
        <div class="form-grid-2">
            <div class="fg"><label>NIP *</label>
            <input type="text" name="nip" placeholder="18 digit NIP"
                    value="<?= old('nip', $item['nip'] ?? '') ?>" required>
            </div>
            <div class="fg">
            <label>Status</label>
            <select name="status">
                <?php foreach (['Aktif','Cuti','Pensiun'] as $s): ?>
                <option <?= old('status', $item['status'] ?? 'Aktif') === $s ? 'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="form-grid-2">
            <div class="fg"><label>Jabatan</label>
            <input type="text" name="jabatan" placeholder="cth: Guru Kelas"
                    value="<?= old('jabatan', $item['jabatan'] ?? '') ?>">
            </div>
            <div class="fg"><label>Mata Pelajaran</label>
            <input type="text" name="mapel" placeholder="cth: Matematika"
                    value="<?= old('mapel', $item['mapel'] ?? '') ?>">
            </div>
        </div>
        <div class="fg"><label>Emoji Avatar</label>
            <input type="text" name="avatar" placeholder="👨‍🏫" maxlength="10"
                value="<?= old('avatar', $item['avatar'] ?? '👨‍🏫') ?>">
        </div>
        <div style="display:flex;gap:12px;margin-top:8px">
            <button type="submit" class="btn btn-primary">💾 <?= $isEdit ? 'Update' : 'Simpan' ?></button>
            <a href="<?= base_url('guru') ?>" class="btn btn-outline">Batal</a>
        </div>
        </form>
    </div>
    </div>