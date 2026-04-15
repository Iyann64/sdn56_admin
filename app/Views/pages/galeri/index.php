    <div class="card">
    <div class="card-header">
        <div class="card-title">🖼️ Galeri Foto</div>
        <button class="btn btn-primary" onclick="document.getElementById('modalGaleri').classList.add('open')">＋ Upload Foto</button>
    </div>
    <div class="card-body">

        <!-- Inline upload form (tersembunyi, dipanggil via modal JS) -->
        <form id="uploadGaleriForm" action="<?= base_url('galeri/upload') ?>" method="POST" enctype="multipart/form-data" style="display:none">
        <?= csrf_field() ?>
        <input type="file"   name="foto"     id="uploadFotoInput">
        <input type="text"   name="nama"     id="uploadNama">
        <input type="text"   name="kategori" id="uploadKategori">
        <input type="text"   name="emoji"    id="uploadEmoji">
        <button type="submit" id="uploadSubmitBtn">Upload</button>
        </form>

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
            $src = $g['file_foto'] ? base_url('uploads/'.$g['file_foto']) : null;
        ?>
        <div class="gm-item" style="position:relative;border-radius:14px;overflow:hidden;aspect-ratio:1;background:<?= $src ? "url('$src') center/cover" : $bg ?>">
            <?php if (!$src): ?>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:40px">
            <?= esc($g['emoji'] ?? '🖼️') ?>
            </div>
            <?php endif; ?>
            <div class="gm-overlay" style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.7),transparent);opacity:0;transition:.3s;display:flex;align-items:flex-end;padding:12px"
                onmouseenter="this.style.opacity='1'" onmouseleave="this.style.opacity='0'">
            <div style="flex:1">
                <div style="font-size:12px;font-weight:600;color:white;margin-bottom:3px"><?= esc($g['nama']) ?></div>
                <div style="font-size:10px;color:rgba(255,255,255,.7)"><?= esc($g['kategori']) ?></div>
            </div>
            <a href="<?= base_url('galeri/hapus/'.$g['id']) ?>"
                onclick="return confirm('Hapus foto ini?')"
                style="background:rgba(239,83,80,.9);color:white;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none">
                🗑️
            </a>
            </div>
        </div>
        <?php endforeach; endif; ?>
        </div>

    </div>
    </div>

    <!-- Override modal galeri supaya submit ke controller -->
    <script>
    function saveGaleri() {
    const nama     = document.getElementById('gNama').value.trim();
    const kategori = document.getElementById('gKategori').value;
    const emoji    = document.getElementById('gEmoji').value || '🖼️';
    if (!nama) { alert('Nama foto wajib diisi.'); return; }
    document.getElementById('uploadNama').value     = nama;
    document.getElementById('uploadKategori').value = kategori;
    document.getElementById('uploadEmoji').value    = emoji;
    document.getElementById('uploadGaleriForm').submit();
    }
    </script>