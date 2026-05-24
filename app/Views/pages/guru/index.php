    <div class="card">
    <div class="card-header">
        <div class="card-title">👨‍🏫 Data Guru & Staf</div>
        <?php if (hasPermission('guru', 'create')): ?>
        <a href="<?= base_url('guru/tambah') ?>" class="btn btn-primary">＋ Tambah Guru</a>
        <?php endif; ?>
    </div>
    <div class="card-body" style="padding:0">
        <div class="table-wrap">
        <table>
            <thead>
            <tr><th>Nama & NIP</th><th>Jabatan</th><th>Mata Pelajaran</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($list)): ?>
            <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--gray)">📭 Belum ada data guru</td></tr>
            <?php else: foreach ($list as $g): ?>
            <tr>
                <td>
                <div style="display:flex;align-items:center;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:var(--c5);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0">
                    <?= esc($g['avatar'] ?? '👨‍🏫') ?>
                    </div>
                    <div>
                    <div style="font-weight:600;color:var(--ink)"><?= esc($g['nama']) ?></div>
                    <div style="font-size:11px;color:var(--gray);font-family:'Fira Code',monospace"><?= esc($g['nip']) ?></div>
                    </div>
                </div>
                </td>
                <td><?= esc($g['jabatan'] ?? '-') ?></td>
                <td><?= esc($g['mapel'] ?? '-') ?></td>
                <td>
                <?php $sc = ['Aktif'=>'badge-success','Cuti'=>'badge-warning','Pensiun'=>'badge-secondary']; ?>
                <span class="badge <?= $sc[$g['status']] ?? 'badge-secondary' ?>"><?= esc($g['status']) ?></span>
                </td>
                <td>
                <div style="display:flex;gap:6px">
                    <?php if (hasPermission('guru', 'edit')): ?>
                    <a href="<?= base_url('guru/edit/'.$g['nip']) ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
                    <?php endif; ?>
                    <?php if (hasPermission('guru', 'delete')): ?>
                    <a href="<?= base_url('guru/hapus/'.$g['nip']) ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus data guru ini?')">🗑️</a>
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
