    <div class="card">
    <div class="card-header">
        <div class="card-title">📅 Agenda & Kegiatan</div>
        <a href="<?= base_url('agenda/tambah') ?>" class="btn btn-primary">＋ Tambah Agenda</a>
    </div>
    <div class="card-body" style="padding:0">
        <div class="table-wrap">
        <table>
            <thead>
            <tr><th>Kegiatan</th><th>Tanggal</th><th>Waktu</th><th>Tempat</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($list)): ?>
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--gray)">📭 Belum ada agenda</td></tr>
            <?php else: foreach ($list as $ag): ?>
            <tr>
                <td><div style="font-weight:600;color:var(--ink)"><?= esc($ag['judul']) ?></div></td>
                <td><?= date('d M Y', strtotime($ag['tanggal'])) ?></td>
                <td><?= $ag['waktu'] ? date('H:i', strtotime($ag['waktu'])).' WIB' : '-' ?></td>
                <td><?= esc($ag['tempat'] ?? '-') ?></td>
                <td><span class="badge badge-info"><?= esc($ag['kategori']) ?></span></td>
                <td>
                <?php $sc = ['Aktif'=>'badge-success','Selesai'=>'badge-secondary','Batal'=>'badge-danger']; ?>
                <span class="badge <?= $sc[$ag['status']] ?? 'badge-secondary' ?>"><?= esc($ag['status']) ?></span>
                </td>
                <td>
                <div style="display:flex;gap:6px">
                    <a href="<?= base_url('agenda/edit/'.$ag['id']) ?>" class="btn btn-outline btn-sm">✏️</a>
                    <a href="<?= base_url('agenda/hapus/'.$ag['id']) ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus agenda ini?')">🗑️</a>
                </div>
                </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>