    <?php /* partials/modals.php — semua modal dialog admin */ ?>

    <!-- ════ Modal Berita ════ -->
    <div class="modal-overlay" id="modalBerita">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title" id="modalBeritaTitle">Tambah Berita</div>
        <div class="modal-close" onclick="closeModal('modalBerita')">✕</div>
        </div>
        <div class="modal-body">
        <form id="formBerita">
            <div class="fg"><label>Judul Berita *</label><input type="text" id="bJudul" placeholder="Judul berita..."></div>
            <div class="form-grid-2">
            <div class="fg">
                <label>Kategori</label>
                <select id="bKategori">
                <option>Prestasi</option><option>Kegiatan</option><option>Akademik</option>
                <option>Lingkungan</option><option>Seni Budaya</option><option>Olahraga</option>
                </select>
            </div>
            <div class="fg">
                <label>Status</label>
                <select id="bStatus"><option>Terbit</option><option>Draf</option></select>
            </div>
            </div>
            <div class="fg"><label>Tanggal *</label><input type="date" id="bTanggal"></div>
            <div class="fg"><label>Isi Berita</label><textarea id="bIsi" placeholder="Tulis isi berita di sini..."></textarea></div>
        </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalBerita')">Batal</button>
        <button class="btn btn-primary" onclick="saveBerita()">💾 Simpan</button>
        </div>
    </div>
    </div>

    <!-- ════ Modal PPDB Tambah ════ -->
    <div class="modal-overlay" id="modalPPDB">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title">Tambah Pendaftar PPDB</div>
        <div class="modal-close" onclick="closeModal('modalPPDB')">✕</div>
        </div>
        <div class="modal-body">
        <form id="formPPDB">
            <div class="fg"><label>Nama Lengkap *</label><input type="text" id="pNama" placeholder="Nama calon siswa"></div>
            <div class="form-grid-2">
            <div class="fg"><label>Tanggal Daftar *</label><input type="date" id="pTgl"></div>
            <div class="fg"><label>Usia (tahun)</label><input type="number" id="pUsia" value="6" min="5" max="8"></div>
            </div>
            <div class="fg"><label>Asal Sekolah / TK</label><input type="text" id="pAsal" placeholder="Nama TK / PAUD asal"></div>
        </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalPPDB')">Batal</button>
        <button class="btn btn-primary" onclick="savePPDB()">💾 Simpan</button>
        </div>
    </div>
    </div>

    <!-- ════ Modal PPDB Detail ════ -->
    <div class="modal-overlay" id="modalPPDBDetail">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title">Detail Pendaftar</div>
        <div class="modal-close" onclick="closeModal('modalPPDBDetail')">✕</div>
        </div>
        <div class="modal-body" id="ppdbDetailContent"></div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalPPDBDetail')">Tutup</button>
        </div>
    </div>
    </div>

    <!-- ════ Modal Agenda ════ -->
    <div class="modal-overlay" id="modalAgenda">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title" id="modalAgendaTitle">Tambah Agenda</div>
        <div class="modal-close" onclick="closeModal('modalAgenda')">✕</div>
        </div>
        <div class="modal-body">
        <form id="formAgenda">
            <div class="fg"><label>Judul Kegiatan *</label><input type="text" id="aJudul" placeholder="Nama kegiatan..."></div>
            <div class="form-grid-2">
            <div class="fg"><label>Tanggal *</label><input type="date" id="aTanggal"></div>
            <div class="fg"><label>Waktu</label><input type="time" id="aWaktu" value="08:00"></div>
            </div>
            <div class="fg"><label>Tempat</label><input type="text" id="aTempat" placeholder="Lokasi kegiatan..."></div>
            <div class="fg">
            <label>Kategori</label>
            <select id="aKategori">
                <option>Akademik</option><option>Rapat</option><option>Upacara</option>
                <option>PPDB</option><option>Ekskul</option><option>Lainnya</option>
            </select>
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalAgenda')">Batal</button>
        <button class="btn btn-primary" onclick="saveAgenda()">💾 Simpan</button>
        </div>
    </div>
    </div>

    <!-- ════ Modal Galeri ════ -->
    <div class="modal-overlay" id="modalGaleri">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title" id="modalGaleriTitle">Upload Foto</div>
        <div class="modal-close" onclick="closeModal('modalGaleri')">✕</div>
        </div>
        <div class="modal-body">
        <form id="formGaleri" action="<?= base_url('galeri/upload') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="file" id="gFoto" name="foto" accept="image/*" style="display:none">
            <div id="uploadZone" style="border:2px dashed var(--c4);border-radius:14px;padding:32px;text-align:center;
                        background:var(--c5);margin-bottom:16px;cursor:pointer;transition:all .2s"
                onmouseenter="this.style.borderColor='var(--c3)'"
                onmouseleave="this.style.borderColor='var(--c4)'"
                onclick="document.getElementById('gFoto').click()">
            <div style="font-size:40px;margin-bottom:8px">📁</div>
            <div style="font-size:14px;font-weight:600;color:var(--c1)">Klik untuk pilih foto</div>
            <div style="font-size:12px;color:var(--gray);margin-top:4px">PNG, JPG, WEBP — maks. 20MB</div>
            <div id="fileName" style="font-size:12px;color:var(--green);margin-top:8px;font-weight:600"></div>
            </div>
            <div class="fg"><label>Nama / Keterangan Foto *</label><input type="text" id="gNama" name="nama" placeholder="Deskripsi singkat foto..."></div>
            <div class="form-grid-2">
            <div class="fg">
                <label>Kategori</label>
                <select id="gKategori" name="kategori">
                <option>Kegiatan</option><option>Prestasi</option><option>Fasilitas</option>
                <option>Lingkungan</option><option>Olahraga</option><option>Seni Budaya</option>
                </select>
            </div>
            <div class="fg"><label>Emoji / Ikon</label><input type="text" id="gEmoji" name="emoji" placeholder="🖼️" maxlength="4"></div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalGaleri')">Batal</button>
        <button type="submit" form="formGaleri" class="btn btn-primary">📤 Upload</button>
        </div>
    </div>
    </div>

    <!-- ════ Modal Guru ════ -->
    <div class="modal-overlay" id="modalGuru">
    <div class="modal">
        <div class="modal-header">
        <div class="modal-title" id="modalGuruTitle">Tambah Guru</div>
        <div class="modal-close" onclick="closeModal('modalGuru')">✕</div>
        </div>
        <div class="modal-body">
        <form id="formGuru">
            <div class="fg"><label>Nama Lengkap & Gelar *</label><input type="text" id="gNamaTxt" placeholder="cth: Budi Santoso, S.Pd"></div>
            <div class="form-grid-2">
            <div class="fg"><label>NIP *</label><input type="text" id="gNip" placeholder="18 digit NIP"></div>
            <div class="fg">
                <label>Status</label>
                <select id="gStatusGuru"><option>Aktif</option><option>Cuti</option><option>Pensiun</option></select>
            </div>
            </div>
            <div class="form-grid-2">
            <div class="fg"><label>Jabatan</label><input type="text" id="gJabatan" placeholder="cth: Guru Kelas"></div>
            <div class="fg"><label>Mata Pelajaran</label><input type="text" id="gMapel" placeholder="cth: Matematika"></div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modalGuru')">Batal</button>
        <button class="btn btn-primary" onclick="saveGuru()">💾 Simpan</button>
        </div>
    </div>
    </div>

    <!-- ════ Confirm Delete Dialog ════ -->
    <div class="modal-overlay" id="confirmOverlay">
    <div class="confirm-dialog">
        <div class="cd-icon">⚠️</div>
        <div class="cd-title">Konfirmasi Hapus</div>
        <p class="cd-msg" id="cdMsg">Apakah Anda yakin?</p>
        <div class="cd-btns">
        <button class="btn btn-outline" onclick="closeConfirm()">Batal</button>
        <button class="btn btn-danger"  onclick="runConfirm()">🗑️ Ya, Hapus</button>
        </div>
    </div>
    </div>