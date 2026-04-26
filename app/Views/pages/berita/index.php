    <div class="card">
    <div class="card-header">
        <div class="card-title">📰 Daftar Berita</div>
        <?php if (hasPermission('berita', 'create')): ?>
        <a href="<?= base_url('berita/tambah') ?>" class="btn btn-primary">＋ Tambah Berita</a>
        <?php endif; ?>
    </div>
    <div class="card-body" style="padding:0">
        <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Judul</th><th>Kategori</th><th>Status</th>
                <th>Tanggal</th><th>Dilihat</th><th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($berita_list)): ?>
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--gray)">📭 Belum ada berita</td></tr>
            <?php else: foreach ($berita_list as $b): ?>
            <tr>
                <td>
                <div style="font-weight:600;color:var(--ink);max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    <?= esc($b['judul']) ?>
                </div>
                </td>
                <td><span class="badge badge-info"><?= esc($b['kategori']) ?></span></td>
                <td>
                <span class="badge <?= $b['status'] === 'Terbit' ? 'badge-success' : 'badge-secondary' ?>">
                    <?= esc($b['status']) ?>
                </span>
                </td>
                <td><?= date('d M Y', strtotime($b['tanggal'])) ?></td>
                <td><?= number_format($b['views'] ?? 0) ?></td>
                <td>
                <div style="display:flex;gap:6px">
                    <?php if (hasPermission('berita', 'edit')): ?>
                    <a href="<?= base_url('berita/edit/'.$b['id']) ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
                    <?php endif; ?>
                    <?php if (hasPermission('berita', 'delete')): ?>
                    <a href="<?= base_url('berita/hapus/'.$b['id']) ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus berita ini?')">🗑️</a>
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>