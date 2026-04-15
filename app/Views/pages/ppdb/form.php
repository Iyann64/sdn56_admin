    <?php
    $item     = $item ?? null;
    $isEdit   = $item !== null;
    $formAction = $isEdit
        ? base_url('ppdb/update/' . $item['id'])
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
            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="nama" class="form-control"
                    placeholder="Nama sesuai akta kelahiran"
                    value="<?= old('nama', $item['nama'] ?? '') ?>" required>
            </div>
            <div class="form-group">
            <label class="form-label">Usia (Tahun)</label>
            <input type="number" name="usia" class="form-control"
                    placeholder="6 atau 7" min="5" max="9"
                    value="<?= old('usia', $item['usia'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
            <label class="form-label">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control"
                    placeholder="Kota kelahiran"
                    value="<?= old('tempat_lahir', $item['tempat_lahir'] ?? '') ?>">
            </div>
            <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control"
                    value="<?= old('tgl_lahir', $item['tgl_lahir'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Asal TK / PAUD</label>
            <input type="text" name="asal" class="form-control"
                placeholder="Nama TK/PAUD asal (kosong jika tidak ada)"
                value="<?= old('asal', $item['asal'] ?? '') ?>">
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
            <label class="form-label">No. Telepon / WhatsApp <span class="req">*</span></label>
            <input type="tel" name="telepon" class="form-control"
                    placeholder="08xx-xxxx-xxxx"
                    value="<?= old('telepon', $item['telepon'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                placeholder="email@contoh.com"
                value="<?= old('email', $item['email'] ?? '') ?>">
        </div>

        <!-- ── Status & Tanggal ───────────────── -->
        <div class="form-section-title" style="margin-top:28px">📋 Status Pendaftaran</div>

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