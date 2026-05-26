/* ═══════════════════════════════════════
   admin-script.js — SDN 56 Admin Panel
═══════════════════════════════════════ */

/* ── DEMO CREDENTIALS ── */
const USERS = [
  { username: 'admin',  password: 'admin123', name: 'Administrator', role: 'Super Admin', avatar: 'A' },
  { username: 'kepala', password: 'sdn56pbm',  name: 'Kepala Sekolah', role: 'Kepala Sekolah', avatar: 'K' },
];

let currentUser = null;
let sidebarCollapsed = false;

/* ═══════════════════════════════════════
   SEED DATA
═══════════════════════════════════════ */
const DATA = {
  berita: [
    { id:1, judul:'Siswa SDN 56 Raih Medali Emas Olimpiade Sains', kategori:'Prestasi', status:'Terbit', tanggal:'2026-02-24', views:1240, thumbnail: null },
    { id:2, judul:'Wisuda & Pelepasan Kelas 6 TA 2025/2026', kategori:'Kegiatan', status:'Terbit', tanggal:'2026-02-20', views:840, thumbnail: null },
    { id:3, judul:'SDN 56 Raih Penghargaan Adiwiyata Provinsi', kategori:'Lingkungan', status:'Terbit', tanggal:'2026-02-15', views:620, thumbnail: null },
    { id:4, judul:'Implementasi Kurikulum Merdeka: Proyek P5', kategori:'Akademik', status:'Draf', tanggal:'2026-02-10', views:0, thumbnail: null },
    { id:5, judul:'Pameran Seni di Festival Budaya Prabumulih', kategori:'Seni Budaya', status:'Terbit', tanggal:'2026-02-05', views:450, thumbnail: null },
    { id:6, judul:'Kegiatan Pramuka Tingkat Ramu Selesai Dilaksanakan', kategori:'Kegiatan', status:'Draf', tanggal:'2026-01-30', views:0, thumbnail: null },
  ],
  ppdb: [
    { id:1, nama:'Muhammad Rafif Akbar',    tgl:'2026-01-15', asal:'TK Permata',   status:'Diterima', usia:7 },
    { id:2, nama:'Siti Aisyah Putri',       tgl:'2026-01-18', asal:'TK Melati',    status:'Diterima', usia:6 },
    { id:3, nama:'Bintang Ramadhan',        tgl:'2026-01-20', asal:'TK Ceria',     status:'Menunggu', usia:6 },
    { id:4, nama:'Naila Rahma Sari',        tgl:'2026-01-22', asal:'TK Anggrek',   status:'Diterima', usia:7 },
    { id:5, nama:'Daffa Rizky Maulana',     tgl:'2026-01-25', asal:'TK Nusantara', status:'Menunggu', usia:6 },
    { id:6, nama:'Zahra Cantika Dewi',      tgl:'2026-01-28', asal:'TK Bintang',   status:'Ditolak',  usia:5 },
  ],
  agenda: [
    { id:1, judul:'Rapat Komite Sekolah',       tanggal:'2026-02-28', waktu:'08:00', tempat:'Aula SDN 56',     kategori:'Rapat',   status:'Aktif' },
    { id:2, judul:'Pembagian Rapor Semester',   tanggal:'2026-03-05', waktu:'07:30', tempat:'Semua Kelas',     kategori:'Akademik', status:'Aktif' },
    { id:3, judul:'UAS Genap 2025/2026',        tanggal:'2026-03-10', waktu:'07:00', tempat:'Semua Kelas',     kategori:'Akademik', status:'Aktif' },
    { id:4, judul:'Pembukaan PPDB 2026/2027',   tanggal:'2026-04-01', waktu:'08:00', tempat:'Kantor Sekolah',  kategori:'PPDB',    status:'Aktif' },
    { id:5, judul:'Peringatan Hari Pendidikan', tanggal:'2026-05-02', waktu:'07:00', tempat:'Lapangan Upacara',kategori:'Upacara', status:'Aktif' },
  ],
  guru: [
    { id:1, nama:'Dra. Hj. Siti Rahayu',  jabatan:'Kepala Sekolah',      mapel:'-',              nip:'196805121992', status:'Aktif', avatar:'👩‍💼' },
    { id:2, nama:'Budi Santoso, S.Pd',    jabatan:'Guru Kelas',           mapel:'Kelas 6A',       nip:'197203181998', status:'Aktif', avatar:'👨‍🏫' },
    { id:3, nama:'Dewi Lestari, S.Pd',   jabatan:'Guru Mata Pelajaran',  mapel:'Matematika',     nip:'198504152010', status:'Aktif', avatar:'👩‍🏫' },
    { id:4, nama:'Rina Wati, S.Pd',       jabatan:'Guru Mata Pelajaran',  mapel:'Bahasa Indonesia',nip:'198901202012', status:'Aktif', avatar:'👩‍🏫' },
    { id:5, nama:'Ahmad Fauzi, S.Pd',     jabatan:'Guru Mata Pelajaran',  mapel:'PJOK',           nip:'199002282015', status:'Aktif', avatar:'👨‍🏫' },
    { id:6, nama:'Yuni Astuti, S.Pd',     jabatan:'Guru Mata Pelajaran',  mapel:'IPA',            nip:'199510102018', status:'Cuti',  avatar:'👩‍🏫' },
  ],
  galeri: [
    { id:1, nama:'Gedung SDN 56', kategori:'Fasilitas', emoji:'🏫', tgl:'2026-01-10' },
    { id:2, nama:'Olimpiade Sains 2026', kategori:'Prestasi', emoji:'🏆', tgl:'2026-02-20' },
    { id:3, nama:'Pentas Seni Tahunan', kategori:'Kegiatan', emoji:'🎭', tgl:'2026-01-25' },
    { id:4, nama:'Turnamen Futsal', kategori:'Olahraga', emoji:'⚽', tgl:'2026-01-28' },
    { id:5, nama:'Program Adiwiyata', kategori:'Lingkungan', emoji:'🌱', tgl:'2026-02-05' },
    { id:6, nama:'Wisuda Kelas 6', kategori:'Kegiatan', emoji:'🎓', tgl:'2026-02-18' },
    { id:7, nama:'Perpustakaan Sekolah', kategori:'Fasilitas', emoji:'📚', tgl:'2026-01-15' },
    { id:8, nama:'Upacara Bendera', kategori:'Kegiatan', emoji:'🎌', tgl:'2026-02-16' },
  ],
};

let editingId = null;
let confirmCallback = null;

/* ═══════════════════════════════════════
   LOGIN
═══════════════════════════════════════ */
function initLogin() {
  if (!document.getElementById("loginForm")) return; // bukan halaman login
  const form      = document.getElementById('loginForm');
  const pwInput   = document.getElementById('loginPw');
  const pwToggle  = document.getElementById('pwToggle');
  const btnLogin  = document.getElementById('btnLogin');
  const loginAlert = document.getElementById('loginAlert');

  // toggle password visibility
  pwToggle.addEventListener('click', () => {
    const show = pwInput.type === 'password';
    pwInput.type = show ? 'text' : 'password';
    pwToggle.textContent = show ? '🙈' : '👁️';
  });

  // form submit
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = document.getElementById('loginUser').value.trim();
    const password = pwInput.value;

    loginAlert.classList.remove('show');

    // basic validation
    let valid = true;
    if (!username) { showInputError('errUser', 'Username harus diisi'); valid = false; }
    else clearInputError('errUser');
    if (!password) { showInputError('errPw', 'Password harus diisi'); valid = false; }
    else clearInputError('errPw');
    if (!valid) return;

    // loading state
    btnLogin.classList.add('loading');

    setTimeout(() => {
      btnLogin.classList.remove('loading');
      const user = USERS.find(u => u.username === username && u.password === password);
      if (user) {
        currentUser = user;
        sessionStorage.setItem('adminUser', JSON.stringify(user));
        enterDashboard(user);
      } else {
        loginAlert.classList.add('show');
        document.getElementById('loginUser').classList.add('error');
        pwInput.classList.add('error');
        showInputError('errPw', 'Username atau password salah');
      }
    }, 1200);
  });

  // clear errors on input
  ['loginUser','loginPw'].forEach(id => {
    document.getElementById(id).addEventListener('input', () => {
      document.getElementById(id).classList.remove('error');
      loginAlert.classList.remove('show');
    });
  });
}

function showInputError(id, msg) {
  const el = document.getElementById(id);
  if (el) { el.textContent = msg; el.classList.add('show'); }
}
function clearInputError(id) {
  const el = document.getElementById(id);
  if (el) el.classList.remove('show');
}

function enterDashboard(user) {
  document.getElementById('loginPage').style.display = 'none';
  document.getElementById('adminLayout').classList.add('active');

  // set user info in sidebar + topbar
  document.querySelectorAll('.js-user-name').forEach(el => el.textContent = user.name);
  document.querySelectorAll('.js-user-role').forEach(el => el.textContent = user.role);
  document.querySelectorAll('.js-user-avatar').forEach(el => el.textContent = user.avatar);

  renderDashboard();
  goPage('dashboard');
}

function logout() {
  currentUser = null;
  sessionStorage.removeItem('adminUser');
  document.getElementById('adminLayout').classList.remove('active');
  document.getElementById('loginPage').style.display = '';
  const _lf = document.getElementById("loginForm"); if (_lf) _lf.reset();
  document.getElementById('loginAlert').classList.remove('show');
  closeDropdown();
}

/* ═══════════════════════════════════════
   SIDEBAR & NAVIGATION
═══════════════════════════════════════ */
function toggleSidebar() {
  sidebarCollapsed = !sidebarCollapsed;
  const sb   = document.getElementById('sidebar');
  const main = document.getElementById('mainArea');
  sb.classList.toggle('collapsed', sidebarCollapsed);
  main.classList.toggle('collapsed', sidebarCollapsed);
  document.getElementById('sbToggleIcon').textContent = sidebarCollapsed ? '›' : '‹';
}

function openMobileSidebar() {
  document.getElementById('sidebar').classList.add('mobile-open');
  const _so1 = document.getElementById('sidebarOverlay'); if (_so1) _so1.classList.add('show');
}
function closeMobileSidebar() {
  document.getElementById('sidebar').classList.remove('mobile-open');
  const _so2 = document.getElementById('sidebarOverlay'); if (_so2) _so2.classList.remove('show');
}

function goPage(name) {
  // pages
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  const pg = document.getElementById('page-' + name);
  if (pg) pg.classList.add('active');

  // sidebar items
  document.querySelectorAll('.sb-item').forEach(i => i.classList.remove('active'));
  const sbItem = document.querySelector(`.sb-item[data-page="${name}"]`);
  if (sbItem) sbItem.classList.add('active');

  // topbar title
  const titles = {
    dashboard: { icon:'📊', title:'Dashboard', breadcrumb:'Beranda' },
    berita:    { icon:'📰', title:'Manajemen Berita', breadcrumb:'Berita' },
    ppdb:      { icon:'✏️', title:'Data PPDB', breadcrumb:'PPDB' },
    agenda:    { icon:'📅', title:'Agenda & Kegiatan', breadcrumb:'Agenda' },
    galeri:    { icon:'🖼️', title:'Manajemen Galeri', breadcrumb:'Galeri' },
    guru:      { icon:'👨‍🏫', title:'Data Guru & Staf', breadcrumb:'Guru & Staf' },
    settings:  { icon:'⚙️', title:'Pengaturan', breadcrumb:'Pengaturan' },
  };
  const t = titles[name] || { icon:'📄', title:name, breadcrumb:name };
  document.getElementById('tbPageIcon').textContent = t.icon;
  document.getElementById('tbPageTitle').textContent = t.title;
  document.getElementById('tbBreadcrumb').textContent = t.breadcrumb;

  // render page data
  const renderers = {
    berita:  renderBerita,
    ppdb:    renderPPDB,
    agenda:  renderAgenda,
    // galeri:  renderGaleri, // Dinonaktifkan agar tidak menimpa data asli dari database
    guru:    renderGuru,
  };
  if (renderers[name]) renderers[name]();

  // close mobile sidebar on nav
  closeMobileSidebar();

  window.scrollTo(0,0);
}

/* ═══════════════════════════════════════
   DASHBOARD
═══════════════════════════════════════ */
function renderDashboard() {
  const totalSiswa = 512, totalGuru = DATA.guru.length;
  const totalBerita = DATA.berita.filter(b => b.status === 'Terbit').length;
  const pendingPPDB = DATA.ppdb.filter(p => p.status === 'Menunggu').length;

  animateNum('dashSiswa', totalSiswa);
  animateNum('dashGuru',  totalGuru);
  animateNum('dashBerita',totalBerita);
  animateNum('dashPPDB',  pendingPPDB);

  // bar chart (class distribution)
  setTimeout(() => {
    document.querySelectorAll('.cb-fill').forEach(el => {
      el.style.width = el.dataset.w;
    });
  }, 300);
}

function animateNum(id, target) {
  const el = document.getElementById(id);
  if (!el) return;
  let cur = 0; const step = target / 40;
  const t = setInterval(() => {
    cur = Math.min(cur + step, target);
    el.textContent = Math.round(cur);
    if (cur >= target) clearInterval(t);
  }, 20);
}

/* ═══════════════════════════════════════
   BERITA
═══════════════════════════════════════ */
function renderBerita() {
  const tbody = document.getElementById('beritaBody');
  if (!tbody) return;
  tbody.innerHTML = DATA.berita.map(b => {
    const isVideo = b.thumbnail && b.thumbnail.match(/\.(mp4|webm|mov)$/i);
    const mediaHtml = b.thumbnail 
      ? (isVideo 
          ? `<video src="${b.thumbnail}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"></video>` 
          : `<img src="${b.thumbnail}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">`)
      : `<div style="width:40px;height:40px;background:var(--c5);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:18px">${b.kategori === 'Prestasi' ? '🏅' : '📰'}</div>`;

    return `
    <tr>
      <td>${mediaHtml}</td>
      <td><strong>${b.judul}</strong></td>
      <td><span class="badge badge-info">${b.kategori}</span></td>
      <td><span class="badge ${b.status === 'Terbit' ? 'badge-success' : 'badge-warning'}">${b.status}</span></td>
      <td>${b.tanggal}</td>
      <td>${b.views.toLocaleString()}</td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-outline btn-sm btn-icon" onclick="openBeritaModal(${b.id})" title="Edit">✏️</button>
          <button class="btn btn-danger btn-sm btn-icon" onclick="confirmDelete('berita',${b.id})" title="Hapus">🗑️</button>
        </div>
      </td>
    </tr>`}).join('');
}

function openBeritaModal(id = null) {
  editingId = id;
  const modal = document.getElementById('modalBerita');
  const title = document.getElementById('modalBeritaTitle');
  if (id) {
    const b = DATA.berita.find(x => x.id === id);
    title.textContent = 'Edit Berita';
    const preview = document.getElementById('bPreview');
    if (preview) { preview.innerHTML = ''; preview.style.display = 'none'; }

    document.getElementById('bJudul').value    = b.judul;
    document.getElementById('bKategori').value = b.kategori;
    document.getElementById('bStatus').value   = b.status;
    document.getElementById('bTanggal').value  = b.tanggal;
    document.getElementById('bIsi').value      = 'Konten berita di sini...';
  } else {
    title.textContent = 'Tambah Berita';
    document.getElementById('formBerita').reset();
    const preview = document.getElementById('bPreview');
    if (preview) { preview.innerHTML = ''; preview.style.display = 'none'; }
  }
  modal.classList.add('open');
}

function saveBerita() {
  const judul    = document.getElementById('bJudul').value.trim();
  const kategori = document.getElementById('bKategori').value;
  const status   = document.getElementById('bStatus').value;
  const tanggal  = document.getElementById('bTanggal').value;
  if (!judul || !tanggal) { showToast('error','Judul dan tanggal wajib diisi!'); return; }

  if (editingId) {
    const idx = DATA.berita.findIndex(x => x.id === editingId);
    if (idx > -1) Object.assign(DATA.berita[idx], { judul, kategori, status, tanggal });
    showToast('success', 'Berita berhasil diperbarui!');
  } else {
    DATA.berita.unshift({ id: Date.now(), judul, kategori, status, tanggal, views: 0 });
    showToast('success', 'Berita berhasil ditambahkan!');
  }
  closeModal('modalBerita');
  renderBerita();
}

/* ═══════════════════════════════════════
   PPDB
═══════════════════════════════════════ */
function renderPPDB() {
  const tbody = document.getElementById('ppdbBody');
  if (!tbody) return;
  tbody.innerHTML = DATA.ppdb.map(p => `
    <tr>
      <td><strong>${p.nama}</strong></td>
      <td>${p.tgl}</td>
      <td>${p.asal}</td>
      <td>${p.usia} tahun</td>
      <td>
        <span class="badge ${p.status === 'Diterima' ? 'badge-success' : p.status === 'Menunggu' ? 'badge-warning' : 'badge-danger'}">
          ${p.status}
        </span>
      </td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-success btn-sm" onclick="updatePPDBStatus(${p.id},'Diterima')">✅</button>
          <button class="btn btn-danger  btn-sm" onclick="updatePPDBStatus(${p.id},'Ditolak')">❌</button>
          <button class="btn btn-outline btn-sm btn-icon" onclick="openPPDBDetail(${p.id})">👁️</button>
        </div>
      </td>
    </tr>`).join('');

  // update summary counts
  const totals = { Diterima:0, Menunggu:0, Ditolak:0 };
  DATA.ppdb.forEach(p => totals[p.status] = (totals[p.status]||0) + 1);
  const el = id => document.getElementById(id);
  if(el('ppdbTotal'))    el('ppdbTotal').textContent    = DATA.ppdb.length;
  if(el('ppdbDiterima')) el('ppdbDiterima').textContent = totals.Diterima;
  if(el('ppdbMenunggu')) el('ppdbMenunggu').textContent = totals.Menunggu;
  if(el('ppdbDitolak'))  el('ppdbDitolak').textContent  = totals.Ditolak;
}

function updatePPDBStatus(id, status) {
  const idx = DATA.ppdb.findIndex(x => x.id === id);
  if (idx > -1) { DATA.ppdb[idx].status = status; renderPPDB(); showToast('success', `Status diperbarui: ${status}`); }
}

function openPPDBDetail(id) {
  const p = DATA.ppdb.find(x => x.id === id);
  if (!p) return;
  document.getElementById('ppdbDetailContent').innerHTML = `
    <div class="form-grid-2">
      <div class="fg"><label>Nama Lengkap</label><input value="${p.nama}" readonly></div>
      <div class="fg"><label>Usia</label><input value="${p.usia} tahun" readonly></div>
      <div class="fg"><label>Tanggal Daftar</label><input value="${p.tgl}" readonly></div>
      <div class="fg"><label>Asal Sekolah</label><input value="${p.asal}" readonly></div>
      <div class="fg"><label>Status</label><input value="${p.status}" readonly></div>
    </div>`;
  document.getElementById('modalPPDBDetail').classList.add('open');
}

function openPPDBModal() {
  editingId = null;
  document.getElementById('formPPDB').reset();
  document.getElementById('modalPPDB').classList.add('open');
}

function savePPDB() {
  const nama  = document.getElementById('pNama').value.trim();
  const tgl   = document.getElementById('pTgl').value;
  const asal  = document.getElementById('pAsal').value.trim();
  const usia  = document.getElementById('pUsia').value;
  if (!nama || !tgl) { showToast('error','Nama dan tanggal wajib diisi!'); return; }
  DATA.ppdb.push({ id:Date.now(), nama, tgl, asal, usia:+usia||6, status:'Menunggu' });
  closeModal('modalPPDB');
  renderPPDB();
  showToast('success','Data pendaftar ditambahkan!');
}

/* ═══════════════════════════════════════
   AGENDA
═══════════════════════════════════════ */
function renderAgenda() {
  const tbody = document.getElementById('agendaBody');
  if (!tbody) return;
  tbody.innerHTML = DATA.agenda.map(a => `
    <tr>
      <td><strong>${a.judul}</strong></td>
      <td>📅 ${a.tanggal} &nbsp;⏰ ${a.waktu}</td>
      <td>${a.tempat}</td>
      <td><span class="badge badge-info">${a.kategori}</span></td>
      <td><span class="badge ${a.status === 'Aktif' ? 'badge-success' : 'badge-gray'}">${a.status}</span></td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-outline btn-sm btn-icon" onclick="openAgendaModal(${a.id})">✏️</button>
          <button class="btn btn-danger  btn-sm btn-icon" onclick="confirmDelete('agenda',${a.id})">🗑️</button>
        </div>
      </td>
    </tr>`).join('');
}

function openAgendaModal(id = null) {
  editingId = id;
  const modal = document.getElementById('modalAgenda');
  document.getElementById('modalAgendaTitle').textContent = id ? 'Edit Agenda' : 'Tambah Agenda';
  if (id) {
    const a = DATA.agenda.find(x => x.id === id);
    document.getElementById('aJudul').value    = a.judul;
    document.getElementById('aTanggal').value  = a.tanggal;
    document.getElementById('aWaktu').value    = a.waktu;
    document.getElementById('aTempat').value   = a.tempat;
    document.getElementById('aKategori').value = a.kategori;
  } else {
    document.getElementById('formAgenda').reset();
  }
  modal.classList.add('open');
}

function saveAgenda() {
  const judul    = document.getElementById('aJudul').value.trim();
  const tanggal  = document.getElementById('aTanggal').value;
  const waktu    = document.getElementById('aWaktu').value;
  const tempat   = document.getElementById('aTempat').value.trim();
  const kategori = document.getElementById('aKategori').value;
  if (!judul || !tanggal) { showToast('error','Judul dan tanggal wajib diisi!'); return; }

  if (editingId) {
    const idx = DATA.agenda.findIndex(x => x.id === editingId);
    if (idx > -1) Object.assign(DATA.agenda[idx], { judul, tanggal, waktu, tempat, kategori });
    showToast('success','Agenda berhasil diperbarui!');
  } else {
    DATA.agenda.push({ id:Date.now(), judul, tanggal, waktu, tempat, kategori, status:'Aktif' });
    showToast('success','Agenda berhasil ditambahkan!');
  }
  closeModal('modalAgenda');
  renderAgenda();
}

/* ═══════════════════════════════════════
   GALERI
═══════════════════════════════════════ */
const GALLERY_COLORS = {
  Fasilitas:   'background:linear-gradient(135deg,#006064,#00838F)',
  Prestasi:    'background:linear-gradient(135deg,#004D40,#00695C)',
  Kegiatan:    'background:linear-gradient(135deg,#0D47A1,#1565C0)',
  Lingkungan:  'background:linear-gradient(135deg,#1B5E20,#2E7D32)',
  Olahraga:   'background:linear-gradient(135deg,#B71C1C,#C62828)',
  'Seni Budaya':'background:linear-gradient(135deg,#4A148C,#6A1B9A)',
};

function renderGaleri() {
  const grid = document.getElementById('galeriGrid');
  if (!grid) return;
  grid.innerHTML = DATA.galeri.map(g => `
    <div class="gm-item" style="${GALLERY_COLORS[g.kategori]||'background:var(--c1)'}">
      <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:40px">${g.emoji}</div>
      <div class="gm-overlay">
        <div style="flex:1">
          <div class="gm-name">${g.nama}</div>
          <div style="font-size:11px;color:rgba(255,255,255,.6);margin-top:2px">${g.kategori}</div>
        </div>
        <div class="gm-actions">
          <button class="gm-btn edit" onclick="event.stopPropagation();openGaleriModal(${g.id}, '${g.nama}', '${g.kategori}', '${g.emoji}')" title="Edit">✏️</button>
          <a class="gm-btn delete" href="#" onclick="event.stopPropagation();confirmDelete('galeri',${g.id})" title="Hapus">🗑️</a>
        </div>
      </div>
    </div>`).join('');
}

/**
 * Lightbox Viewer untuk melihat foto/video full size
 */
function viewGaleri(src, isVideo) {
    const content = document.getElementById('viewerContent');
    if (!src || !content) return;

    if (isVideo) {
        content.innerHTML = `<video src="${src}" controls autoplay style="max-width:100%; max-height:85vh; display:block; outline:none;"></video>`;
    } else {
        content.innerHTML = `<img src="${src}" style="max-width:100%; max-height:85vh; object-fit:contain; display:block;">`;
    }
    document.getElementById('modalViewer').classList.add('open');
}

function openGaleriModal(id = '', nama = '', kategori = '', emoji = '', currentFile = '', isVideo = false)
{
    const form = document.getElementById('formGaleri');
    const modal = document.getElementById('modalGaleri');
    if (!form || !modal) return;

    const uploadUrl = form.dataset.upload;
    const updateUrl = form.dataset.update;

    // Reset preview setiap kali modal dibuka
    const previewContainer = document.getElementById('previewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileName = document.getElementById('fileName');
    if (previewContainer) previewContainer.innerHTML = '';
    if (uploadPlaceholder) uploadPlaceholder.style.display = 'block';
    if (fileName) fileName.textContent = '';

    if (id && !updateUrl) {
        console.error("Atribut data-update tidak ditemukan pada formGaleri!");
        return showToast('error', 'Konfigurasi URL Update bermasalah.');
    }

    document.getElementById('modalGaleriTitle').textContent =
        id ? 'Edit Foto' : 'Upload Foto';

    if (id) {
        form.action = updateUrl + '/' + id;
        
        document.getElementById('gFoto').multiple = false;
        document.getElementById('gNama').value = nama;
        document.getElementById('gKategori').value = kategori;
        document.getElementById('gEmoji').value = emoji;

        // Tampilkan preview file yang sudah ada di server
        if (currentFile) {
            if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
            const div = document.createElement('div');
            div.style.cssText = 'width:100%;aspect-ratio:1;border-radius:8px;overflow:hidden;background:#333;border:2px solid var(--c1);position:relative';
            if (isVideo) {
                div.innerHTML = `<video src="${currentFile}" style="width:100%;height:100%;object-fit:cover"></video>`;
            } else {
                div.innerHTML = `<img src="${currentFile}" style="width:100%;height:100%;object-fit:cover">`;
            }
            if (previewContainer) previewContainer.appendChild(div);
            if (fileName) {
                fileName.textContent = 'File saat ini aktif';
                fileName.style.color = 'var(--c1)';
            }
        }
    } else {
        form.action = uploadUrl;
        form.reset();
        document.getElementById('gFoto').multiple = true;
    }
    modal.classList.add('open');
}


// Handle file selection
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('gFoto');
  if (fileInput) {
    fileInput.addEventListener('change', function() {
      const fileName = document.getElementById('fileName');
      const previewContainer = document.getElementById('previewContainer');
      const uploadPlaceholder = document.getElementById('uploadPlaceholder');
      
      if (previewContainer) previewContainer.innerHTML = '';

      if (this.files && this.files.length > 0) {
        if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
        const count = this.files.length;
        fileName.textContent = count > 1 ? `✓ ${count} file dipilih` : `✓ ${this.files[0].name}`;
        fileName.style.color = 'var(--green)';

        // Loop untuk membuat preview
        Array.from(this.files).forEach(file => {
          const div = document.createElement('div');
          div.style.cssText = 'width:100%;aspect-ratio:1;border-radius:8px;overflow:hidden;background:#eee;border:1px solid #ddd;position:relative';
          
          const url = URL.createObjectURL(file);
          
          if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = url;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover';
            div.appendChild(img);
          } else if (file.type.startsWith('video/')) {
            const vid = document.createElement('video');
            vid.src = url;
            vid.style.cssText = 'width:100%;height:100%;object-fit:cover';
            div.appendChild(vid);
          }
          if (previewContainer) previewContainer.appendChild(div);
        });
      } else {
        if (uploadPlaceholder) uploadPlaceholder.style.display = 'block';
        fileName.textContent = '';
      }
    });
  }
});

/* ═══════════════════════════════════════
   GURU
═══════════════════════════════════════ */
function renderGuru() {
  const tbody = document.getElementById('guruBody');
  if (!tbody) return;
  tbody.innerHTML = DATA.guru.map(g => `
    <tr>
      <td>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="width:36px;height:36px;border-radius:10px;background:var(--c5);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">${g.avatar}</div>
          <div><div style="font-weight:600">${g.nama}</div><div style="font-size:11px;color:var(--gray);font-family:'Fira Code',monospace">NIP: ${g.nip}</div></div>
        </div>
      </td>
      <td>${g.jabatan}</td>
      <td>${g.mapel}</td>
      <td><span class="badge ${g.status === 'Aktif' ? 'badge-success' : 'badge-warning'}">${g.status}</span></td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-outline btn-sm btn-icon" onclick="openGuruModal(${g.id})">✏️</button>
          <button class="btn btn-danger  btn-sm btn-icon" onclick="confirmDelete('guru',${g.id})">🗑️</button>
        </div>
      </td>
    </tr>`).join('');
}

function openGuruModal(id = null) {
  editingId = id;
  document.getElementById('modalGuruTitle').textContent = id ? 'Edit Data Guru' : 'Tambah Guru';
  if (id) {
    const g = DATA.guru.find(x => x.id === id);
    document.getElementById('gNamaTxt').value   = g.nama;
    document.getElementById('gJabatan').value   = g.jabatan;
    document.getElementById('gMapel').value     = g.mapel;
    document.getElementById('gNip').value       = g.nip;
    document.getElementById('gStatusGuru').value= g.status;
  } else {
    document.getElementById('formGuru').reset();
  }
  document.getElementById('modalGuru').classList.add('open');
}

function saveGuru() {
  const nama    = document.getElementById('gNamaTxt').value.trim();
  const jabatan = document.getElementById('gJabatan').value.trim();
  const mapel   = document.getElementById('gMapel').value.trim();
  const nip     = document.getElementById('gNip').value.trim();
  const status  = document.getElementById('gStatusGuru').value;
  if (!nama || !nip) { showToast('error','Nama dan NIP wajib diisi!'); return; }

  if (editingId) {
    const idx = DATA.guru.findIndex(x => x.id === editingId);
    if (idx > -1) Object.assign(DATA.guru[idx], { nama, jabatan, mapel, nip, status });
    showToast('success','Data guru diperbarui!');
  } else {
    DATA.guru.push({ id:Date.now(), nama, jabatan, mapel, nip, status, avatar:'👨‍🏫' });
    showToast('success','Data guru ditambahkan!');
  }
  closeModal('modalGuru');
  renderGuru();
}

/* ═══════════════════════════════════════
   SETTINGS
═══════════════════════════════════════ */
function settingsNav(name) {
  document.querySelectorAll('.sn-item').forEach(i => i.classList.remove('active'));
  document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
  document.querySelector(`.sn-item[data-sec="${name}"]`).classList.add('active');
  document.getElementById('sec-' + name).classList.add('active');
}

function changePassword() {
  const current = document.getElementById('pwCurrent').value;
  const newPw   = document.getElementById('pwNew').value;
  const confirm = document.getElementById('pwConfirm').value;
  if (!current || !newPw || !confirm) { showToast('warning','Semua field wajib diisi!'); return; }
  if (newPw !== confirm) { showToast('error','Password baru tidak cocok!'); return; }
  if (newPw.length < 6)  { showToast('error','Password minimal 6 karakter!'); return; }
  showToast('success','Password berhasil diubah!');
  document.getElementById('formPassword').reset();
  document.getElementById('pwStrengthFill').style.width = '0';
}

function checkPwStrength() {
  const pw = document.getElementById('pwNew').value;
  const fill = document.getElementById('pwStrengthFill');
  let strength = 0;
  if (pw.length >= 6)  strength++;
  if (pw.length >= 10) strength++;
  if (/[A-Z]/.test(pw)) strength++;
  if (/[0-9]/.test(pw)) strength++;
  if (/[^A-Za-z0-9]/.test(pw)) strength++;
  const pct = Math.min(strength * 20, 100);
  const colors = ['','#EF5350','#FB8C00','#FDD835','#66BB6A','#2E7D32'];
  fill.style.width = pct + '%';
  fill.style.background = colors[strength] || '#EF5350';
}

/* ═══════════════════════════════════════
   MODAL HELPERS
═══════════════════════════════════════ */
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
  editingId = null;
}

// close modal on overlay click
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('open');
    editingId = null;
  }
});

/* ═══════════════════════════════════════
   CONFIRM DELETE
═══════════════════════════════════════ */
function confirmDelete(type, id) {
  const labels = { berita:'berita ini', ppdb:'data pendaftar ini', agenda:'agenda ini', galeri:'foto ini', guru:'data guru ini' };
  document.getElementById('cdMsg').textContent = `Apakah Anda yakin ingin menghapus ${labels[type] || 'item ini'}? Tindakan ini tidak dapat dibatalkan.`;
  confirmCallback = () => {
    const idx = DATA[type].findIndex(x => x.id === id);
    if (idx > -1) DATA[type].splice(idx, 1);
    const renderers = { berita:renderBerita, ppdb:renderPPDB, agenda:renderAgenda, galeri:renderGaleri, guru:renderGuru };
    if (renderers[type]) renderers[type]();
    showToast('success','Data berhasil dihapus!');
    closeConfirm();
  };
  document.getElementById('confirmOverlay').classList.add('open');
}

function runConfirm()  { if (confirmCallback) confirmCallback(); }
function closeConfirm(){ document.getElementById('confirmOverlay').classList.remove('open'); confirmCallback = null; }

/* ═══════════════════════════════════════
   TOAST
═══════════════════════════════════════ */
const TOAST_ICONS = { success:'✅', error:'❌', warning:'⚠️', info:'ℹ️' };

function showToast(type, msg) {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `<span class="toast-icon">${TOAST_ICONS[type]||'ℹ️'}</span><span class="toast-msg">${msg}</span>`;
  container.appendChild(toast);
  setTimeout(() => { toast.classList.add('out'); setTimeout(() => toast.remove(), 300); }, 3000);
}

/* ═══════════════════════════════════════
   DROPDOWN (topbar profile)
═══════════════════════════════════════ */
function toggleDropdown() {
  document.getElementById('profileDropdown').classList.toggle('open');
}
function closeDropdown() {
  document.getElementById('profileDropdown').classList.remove('open');
}
document.addEventListener('click', (e) => {
  if (!e.target.closest('.dropdown')) closeDropdown();
});

/* ═══════════════════════════════════════
   INIT
═══════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

  // ── Login page init (hanya jika element login ada) ──
  initLogin();

  // ── Admin layout init (hanya jika sudah login / bukan halaman login) ──
  const adminLayout = document.getElementById('adminLayout');
  if (!adminLayout) return; // halaman login, stop di sini

  // Sidebar overlay
  const _ov = document.getElementById('sidebarOverlay');
  if (_ov) _ov.addEventListener('click', closeMobileSidebar);

  // Sidebar toggle state dari localStorage
  const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
  if (collapsed) {
    document.getElementById('sidebar')?.classList.add('collapsed');
    const icon = document.getElementById('sbToggleIcon');
    if (icon) icon.textContent = '›';
  }

  // Animasi chart bar (dashboard)
  document.querySelectorAll('.cb-fill[data-w]').forEach(el => {
    setTimeout(() => { el.style.width = el.dataset.w; }, 300);
  });

  // Count-up stat cards
  document.querySelectorAll('.sc-num[data-target]').forEach(el => {
    const target = +el.dataset.target;
    if (!target) return;
    let cur = 0;
    const step = Math.max(target / 60, 1);
    const timer = setInterval(() => {
      cur = Math.min(cur + step, target);
      el.textContent = Math.floor(cur);
      if (cur >= target) { el.textContent = target; clearInterval(timer); }
    }, 16);
  });

});