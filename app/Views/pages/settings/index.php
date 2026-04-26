    <div class="settings-grid">

    <!-- Nav -->
    <div class="card" style="padding:16px;height:fit-content">
        <div class="settings-nav">
        <div class="sn-item active" data-sec="profil"   onclick="settingsNav('profil')">👤 Profil Admin</div>
        <div class="sn-item" data-sec="password"        onclick="settingsNav('password')">🔒 Ubah Password</div>
        <div class="sn-item" data-sec="sekolah"         onclick="settingsNav('sekolah')">🏫 Info Sekolah</div>
        <div class="sn-item" data-sec="ppdb-set"        onclick="settingsNav('ppdb-set')">✏️ Konfigurasi PPDB</div>
        <div class="sn-item" data-sec="tentang"         onclick="settingsNav('tentang')">ℹ️ Tentang Sistem</div>
        </div>
    </div>

    <!-- Content -->
    <div>

        <!-- ── Profil ── -->
        <div class="settings-section active card card-body" id="sec-profil">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:20px">Profil Administrator</h3>
        <div class="profile-pic-area">
            <div class="profile-pic" style="font-size:32px"><?= esc($user['avatar'] ?? 'A') ?></div>
            <div>
            <div style="font-size:14px;font-weight:600;color:var(--ink)"><?= esc($user['nama'] ?? 'Admin') ?></div>
            <div style="font-size:12px;color:var(--gray);margin-bottom:10px"><?= esc($user['role'] ?? '') ?></div>
            <button class="btn btn-outline btn-sm">📷 Ganti Foto</button>
            </div>
        </div>
        <form action="<?= base_url('settings/profil') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-grid-2">
            <div class="fg"><label>Nama Lengkap</label><input type="text" name="nama" value="<?= esc($user['nama'] ?? '') ?>"></div>
            <div class="fg"><label>Email</label><input type="email" name="email" value="<?= esc($user['email'] ?? '') ?>"></div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
        </div>

        <!-- ── Password ── -->
        <div class="settings-section card card-body" id="sec-password">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:20px">Ubah Password</h3>
        <form action="<?= base_url('settings/password') ?>" method="POST" style="max-width:440px">
            <?= csrf_field() ?>
            <div class="fg"><label>Password Saat Ini</label><input type="password" name="pw_current" placeholder="********"></div>
            <div class="fg"><label>Password Baru</label><input type="password" name="pw_new" placeholder="Min. 6 karakter"></div>
            <div class="fg"><label>Konfirmasi Password</label><input type="password" name="pw_confirm" placeholder="Ulangi password baru"></div>
            <button type="submit" class="btn btn-primary">🔒 Simpan Password</button>
        </form>
        </div>

        <!-- ── Info Sekolah ── -->
        <div class="settings-section card card-body" id="sec-sekolah">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:20px">Informasi Sekolah</h3>
        <form action="<?= base_url('settings/sekolah') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-grid-2">
            <div class="fg"><label>Nama Sekolah</label>  <input name="nama"    value="<?= esc($sekolah['nama'] ?? '') ?>"></div>
            <div class="fg"><label>NPSN</label>           <input name="npsn"    value="<?= esc($sekolah['npsn'] ?? '') ?>"></div>
            <div class="fg"><label>Kepala Sekolah</label> <input name="kepala"  value="<?= esc($sekolah['kepala'] ?? '') ?>"></div>
            <div class="fg"><label>Akreditasi</label>     <input name="akred"   value="<?= esc($sekolah['akreditasi'] ?? '') ?>"></div>
            <div class="fg"><label>Telepon</label>        <input name="telepon" value="<?= esc($sekolah['telepon'] ?? '') ?>"></div>
            <div class="fg"><label>Email Sekolah</label>  <input name="email"   value="<?= esc($sekolah['email'] ?? '') ?>"></div>
            </div>
            <div class="fg"><label>Alamat Lengkap</label><textarea name="alamat"><?= esc($sekolah['alamat'] ?? '') ?></textarea></div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
        </div>

        <!-- ── PPDB Config ── -->
        <div class="settings-section card card-body" id="sec-ppdb-set">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:20px">Konfigurasi PPDB</h3>
        <form action="<?= base_url('settings/ppdb-config') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-grid-2">
            <div class="fg"><label>Tanggal Buka</label>        <input type="date" name="tgl_buka"  value="<?= esc($ppdb_config['tgl_buka'] ?? '') ?>"></div>
            <div class="fg"><label>Tanggal Tutup</label>       <input type="date" name="tgl_tutup" value="<?= esc($ppdb_config['tgl_tutup'] ?? '') ?>"></div>
            <div class="fg"><label>Kuota Rombel</label>        <input type="number" name="kuota_rombel" value="<?= esc($ppdb_config['kuota_rombel'] ?? 4) ?>"></div>
            <div class="fg"><label>Kuota per Rombel</label>    <input type="number" name="kuota_per_rombel" value="<?= esc($ppdb_config['kuota_per_rombel'] ?? 28) ?>"></div>
            <div class="fg"><label>Usia Minimal (tahun)</label><input type="number" name="usia_min" value="<?= esc($ppdb_config['usia_min'] ?? 6) ?>"></div>
            <div class="fg"><label>Usia Maksimal (tahun)</label><input type="number" name="usia_max" value="<?= esc($ppdb_config['usia_max'] ?? 7) ?>"></div>
            </div>
            <div class="fg">
            <label>Status Penerimaan</label>
            <select name="status">
                <?php foreach (['Belum Dibuka','Sedang Berlangsung','Ditutup'] as $s): ?>
                <option <?= ($ppdb_config['status'] ?? '') === $s ? 'selected':'' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Konfigurasi</button>
        </form>
        </div>

        <!-- ── Tentang ── -->
        <div class="settings-section card card-body" id="sec-tentang">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--ink);margin-bottom:20px">Tentang Sistem</h3>
        <div style="display:flex;flex-direction:column;gap:14px">
            <div style="display:flex;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--light)"><span style="font-weight:600;color:var(--gray)">Nama Sistem</span><span style="font-weight:700">SDN 56 Admin Panel</span></div>
            <div style="display:flex;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--light)"><span style="font-weight:600;color:var(--gray)">Versi</span><span style="font-weight:700">v1.0.0</span></div>
            <div style="display:flex;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--light)"><span style="font-weight:600;color:var(--gray)">Framework</span><span style="font-weight:700">CodeIgniter 4.6</span></div>
            <div style="display:flex;justify-content:space-between;padding:14px 0"><span style="font-weight:600;color:var(--gray)">Status Sistem</span><span class="badge badge-success">Online & Normal</span></div>
        </div>
        <div style="margin-top:24px;padding:16px;background:var(--c5);border-radius:12px;font-size:13px;color:var(--c1);border-left:3px solid var(--c3)">
            ℹ️ Sistem ini digunakan untuk mengelola konten website SD Negeri 56 Prabumulih secara terpusat.
        </div>
        </div>

    </div>
    </div>

    <script>
    function settingsNav(sec) {
    document.querySelectorAll('.sn-item').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.settings-section').forEach(el => el.classList.remove('active'));
    document.querySelector(`.sn-item[data-sec="${sec}"]`).classList.add('active');
    document.getElementById(`sec-${sec}`).classList.add('active');
    }
    </script>