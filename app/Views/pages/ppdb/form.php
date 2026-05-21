    <?php
    $item     = $item ?? [];
    $id       = $item['id'] ?? null;
    $isEdit   = $id !== null;
    $formAction = $isEdit
        ? base_url('ppdb/update/' . $id)
        : base_url('ppdb/simpan');
    ?>

    <!-- Tombol kembali -->
    <div style="margin-bottom:20px">
    <a href="<?= base_url('ppdb') ?>"
        style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;background:var(--light);color:var(--ink);font-size:13px;font-weight:600;text-decoration:none;border:1.5px solid var(--c4)">
        ← Kembali ke Daftar PPDB
    </a>
    </div>

    <div class="card" style="max-width:760px">
    <div class="card-header">
        <h3 class="card-title">
        <?= $isEdit ? '✏️ Edit Data Pendaftar' : '➕ Tambah Pendaftar Baru' ?>
        </h3>
    </div>
    <div class="card-body">

        <form action="<?= $formAction ?>" method="POST">
        <?= csrf_field() ?>

        <!-- ── Data Siswa ─────────────────────── -->
        <div class="form-section-title">👤 Data Calon Siswa</div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Nama Lengkap Siswa <span class="req">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control"
                    placeholder="Nama sesuai akta kelahiran"
                    value="<?= old('nama_lengkap', $item['nama'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">NIK Siswa <span class="req">*</span></label>
            <input type="text" name="nik_siswa" class="form-control"
                    placeholder="16 digit NIK"
                    value="<?= old('nik_siswa', $item['nik_siswa'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">NISN (Jika ada)</label>
            <input type="text" name="nisn" class="form-control"
                    placeholder="Nomor Induk Siswa Nasional"
                    value="<?= old('nisn', $item['nisn'] ?? '') ?>">
            </div>
            <div class="form-group">
            <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih...</option>
                <option value="Laki-laki" <?= old('jenis_kelamin', $item['jenis_kelamin'] ?? '') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin', $item['jenis_kelamin'] ?? '') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Tempat Lahir <span class="req">*</span></label>
            <input type="text" name="tempat_lahir" class="form-control"
                    placeholder="Kota kelahiran"
                    value="<?= old('tempat_lahir', $item['tempat_lahir'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">Agama <span class="req">*</span></label>
            <select name="agama" class="form-control" required>
                <?php foreach (['Islam','Kristen','Katolik','Hindu','Budha','Khonghucu'] as $ag): ?>
                <option value="<?= $ag ?>" <?= old('agama', $item['agama'] ?? '') === $ag ? 'selected' : '' ?>><?= $ag ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
            <input type="date" name="tgl_lahir" class="form-control"
                    value="<?= old('tgl_lahir', $item['tgl_lahir'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">Usia Saat Ini</label>
            <input type="number" name="usia" class="form-control"
                    placeholder="6 atau 7" min="5" max="9"
                    value="<?= old('usia', $item['usia'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Kewarganegaraan</label>
            <input type="text" name="kewarganegaraan" class="form-control"
                    value="<?= old('kewarganegaraan', $item['kewarganegaraan'] ?? 'WNI') ?>">
            </div>
            <div class="form-group">
            <label class="form-label">Kondisi Kesehatan</label>
            <input type="text" name="status_kesehatan" class="form-control"
                    placeholder="Alergi/Penyakit (jika ada)"
                    value="<?= old('status_kesehatan', $item['status_kesehatan'] ?? '') ?>">
            </div>
        </div>

        <!-- ── Data Orang Tua ─────────────────── -->
        <div class="form-section-title" style="margin-top:28px">👨‍👩‍👧 Data Orang Tua / Wali</div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Nama Orang Tua / Wali <span class="req">*</span></label>
            <input type="text" name="nama_ortu" class="form-control"
                    placeholder="Nama lengkap"
                    value="<?= old('nama_ortu', $item['nama_ortu'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">NIK Orang Tua / Wali <span class="req">*</span></label>
            <input type="text" name="nik_ortu" class="form-control"
                    placeholder="16 digit NIK"
                    value="<?= old('nik_ortu', $item['nik_ortu'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan_ortu" class="form-control"
                    placeholder="Contoh: Karyawan Swasta"
                    value="<?= old('pekerjaan_ortu', $item['pekerjaan_ortu'] ?? '') ?>">
            </div>
            <div class="form-group">
            <label class="form-label">Agama Orang Tua <span class="req">*</span></label>
            <select name="agama_ortu" class="form-control" required>
                <option value="">Pilih...</option>
                <?php foreach (['Islam','Kristen','Katolik','Hindu','Budha','Khonghucu'] as $ag): ?>
                <option value="<?= $ag ?>" <?= old('agama_ortu', $item['agama_ortu'] ?? '') === $ag ? 'selected' : '' ?>><?= $ag ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Hubungan <span class="req">*</span></label>
            <select name="hubungan" class="form-control" required>
                <?php foreach (['Ayah','Ibu','Wali'] as $h): ?>
                <option value="<?= $h ?>" <?= old('hubungan', $item['hubungan'] ?? '') === $h ? 'selected' : '' ?>><?= $h ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="form-group">
            <label class="form-label">No. Telepon / WhatsApp <span class="req">*</span></label>
            <input type="tel" name="telepon" class="form-control"
                    placeholder="08xx-xxxx-xxxx"
                    value="<?= old('telepon', $item['telepon'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Email Aktif <span class="req">*</span></label>
            <input type="email" name="email" class="form-control"
                placeholder="email@contoh.com"
                value="<?= old('email', $item['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control"
                    placeholder="5 digit"
                    value="<?= old('kode_pos', $item['kode_pos'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap <span class="req">*</span></label>
            <textarea name="alamat" class="form-control" rows="3" required
                placeholder="Jl. Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan"><?= old('alamat', $item['alamat'] ?? '') ?></textarea>
        </div>

        <!-- ── Asal Sekolah ───────────────────── -->
        <div class="form-section-title" style="margin-top:28px">🏫 Asal Sekolah</div>

        <div class="form-group">
            <label class="form-label">Asal TK / PAUD</label>
            <input type="text" name="asal_sekolah" class="form-control"
                placeholder="Nama TK/PAUD asal (kosong jika tidak ada)"
                value="<?= old('asal_sekolah', $item['asal'] ?? '') ?>">
        </div>

        <!-- ── Status & Tanggal ───────────────── -->
        <div class="form-section-title" style="margin-top:28px">📋 Status Pendaftaran</div>
        <div>
            <label class="form-label">Jalur Pendaftaran</label>
            <select name="jalur_pendaftaran" class="form-control">
                <option value="">Pilih Jalur</option>
                <option value="Zonasi">Zonasi</option>
                <option value="Afirmasi">Afirmasi</option>
                <option value="Prestasi">Prestasi</option>
                <option value="Perpindahan Tugas Orang Tua">Perpindahan Tugas Orang Tua</option>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Tanggal Daftar <span class="req">*</span></label>
            <input type="date" name="tgl_daftar" class="form-control"
                    value="<?= old('tgl_daftar', $item['tgl_daftar'] ?? date('Y-m-d')) ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <?php foreach (['Menunggu', 'Diterima', 'Ditolak'] as $s): ?>
                <option value="<?= $s ?>"
                <?= old('status', $item['status'] ?? 'Menunggu') === $s ? 'selected' : '' ?>>
                <?= $s ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="3" 
                style="height: auto; resize: vertical;"
                placeholder="Catatan medis, prestasi, atau informasi penting lainnya..."><?= old('catatan', $item['catatan'] ?? '') ?></textarea>
        </div>

        <!-- ── Tombol ─────────────────────────── -->
        <div style="display:flex;gap:12px;margin-top:32px;padding-top:24px;border-top:2px solid var(--light)">
            <button type="submit" class="btn btn-primary">
            <?= $isEdit ? '💾 Simpan Perubahan' : '➕ Tambah Pendaftar' ?>
            </button>
            <a href="<?= base_url('ppdb') ?>" class="btn btn-secondary">Batal</a>
        </div>

        </form>
    </div>
    </div>

    <style>
    .form-section-title {
    font-size: 12px;
    font-weight: 800;
    color: var(--c1);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--c5);
    }
    .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
    .form-label .req { color: #EF5350; }
    .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid var(--c5);
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    color: var(--ink);
    background: var(--white);
    transition: border-color .2s;
    outline: none;
    box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--c3); }
    .btn { padding: 11px 24px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; transition: all .2s; }
    .btn-primary  { background: linear-gradient(135deg, var(--c1), var(--c2)); color: white; }
    .btn-secondary{ background: var(--light); color: var(--ink); border: 2px solid var(--c4); }
    @media(max-width:600px) { .form-row { grid-template-columns: 1fr; } }
    </style>