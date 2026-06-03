<?php $canEditKonten = hasPermission('ppdb_konten', 'edit'); ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Pengaturan Jadwal Per Jalur</div>
    </div>
    <div class="card-body">
        <p style="margin-bottom: 20px; font-size: 14px; color: var(--gray);">
            Atur rentang waktu pendaftaran untuk masing-masing jalur. Jadwal ini akan muncul pada Bukti Pendaftaran (PDF) siswa.
        </p>

        <form action="<?= base_url('ppdb/jadwal/simpan') ?>" method="POST">
            <?= csrf_field() ?>
            <fieldset <?= $canEditKonten ? '' : 'disabled' ?> style="border:0; padding:0; margin:0;">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:70px">No.</th>
                                <th>Jalur Pendaftaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th style="text-align:center">Aktif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jadwal as $j): ?>
                            <input type="hidden" name="id[]" value="<?= $j['id_ppdb_jadwal'] ?>">
                            <tr>
                                <td><?= esc($j['id_ppdb_jadwal']) ?></td>
                                <td><strong><?= esc($j['jalur']) ?></strong></td>
                                <td>
                                    <input type="date" name="tgl_mulai[<?= $j['id_ppdb_jadwal'] ?>]"
                                           value="<?= $j['tgl_mulai'] ?>" class="form-control">
                                </td>
                                <td>
                                    <input type="date" name="tgl_akhir[<?= $j['id_ppdb_jadwal'] ?>]"
                                           value="<?= $j['tgl_akhir'] ?>" class="form-control">
                                </td>
                                <td style="text-align:center">
                                    <input type="checkbox" name="aktif[]" value="<?= $j['id_ppdb_jadwal'] ?>"
                                           <?= $j['aktif'] ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>

            <?php if ($canEditKonten): ?>
            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan Jadwal</button>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
