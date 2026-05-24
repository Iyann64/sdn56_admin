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
                <th style="width:60px">Media</th><th>Judul</th><th>Kategori</th><th>Status</th>
                <th>Tanggal</th><th>Dilihat</th><th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($berita_list)): ?>
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--gray)">📭 Belum ada berita</td></tr>
            <?php else: foreach ($berita_list as $b): 
                $ext = $b['thumbnail'] ? pathinfo($b['thumbnail'], PATHINFO_EXTENSION) : '';
                $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'mov']);
                $thumbUrl = $b['thumbnail'] ? $upload_url . 'berita/' . $b['thumbnail'] : null;
            ?>
            <tr>
                <td>
                    <?php if ($thumbUrl): ?>
                        <?php if ($isVideo): ?>
                            <video src="<?= $thumbUrl ?>" muted style="width:40px; height:40px; object-fit:cover; border-radius:8px;"></video>
                        <?php else: ?>
                            <img src="<?= $thumbUrl ?>" style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="width:40px; height:40px; background:#f0f2f5; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:18px;">📰</div>
                    <?php endif; ?>
                </td>
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
                    <a href="<?= base_url('berita/edit/'.$b['id_berita']) ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
                    <?php endif; ?>
                    <?php if (hasPermission('berita', 'delete')): ?>
                    <a href="<?= base_url('berita/hapus/'.$b['id_berita']) ?>"
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
