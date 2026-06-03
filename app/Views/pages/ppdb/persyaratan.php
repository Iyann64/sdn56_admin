<?php $canEditKonten = hasPermission('ppdb_konten', 'edit'); ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Manajemen Dokumen Persyaratan</div>
    </div>
    <div class="card-body">
        <p style="margin-bottom: 20px; font-size: 14px; color: var(--gray);">
            Tentukan dokumen yang harus disiapkan oleh wali murid. Pengaturan "Wajib" akan memberikan tanda bintang pada formulir dan daftar ceklis di PDF.
        </p>

        <form action="<?= base_url('ppdb/persyaratan/simpan') ?>" method="POST">
            <?= csrf_field() ?>
            <fieldset <?= $canEditKonten ? '' : 'disabled' ?> style="border:0; padding:0; margin:0;">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:70px">No.</th>
                                <th width="250">Nama Dokumen</th>
                                <th>Keterangan / Deskripsi</th>
                                <th style="text-align:center">Wajib</th>
                                <th style="text-align:center">Aktif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dokumen as $d): ?>
                            <input type="hidden" name="id[]" value="<?= $d['id_ppdb_dokumen'] ?>">
                            <tr>
                                <td><?= esc($d['id_ppdb_dokumen']) ?></td>
                                <td>
                                    <input type="text" name="nama[<?= $d['id_ppdb_dokumen'] ?>]"
                                           value="<?= esc($d['nama']) ?>" class="form-control" style="font-weight:700">
                                </td>
                                <td>
                                    <input type="text" name="deskripsi[<?= $d['id_ppdb_dokumen'] ?>]"
                                           value="<?= esc($d['deskripsi'] ?? '') ?>" class="form-control" placeholder="Contoh: Format PDF/JPG, maksimal 2MB">
                                </td>
                                <td style="text-align:center">
                                    <label class="switch">
                                        <input type="checkbox" name="wajib[]" value="<?= $d['id_ppdb_dokumen'] ?>" <?= $d['wajib'] ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="text-align:center">
                                    <label class="switch">
                                        <input type="checkbox" name="aktif[]" value="<?= $d['id_ppdb_dokumen'] ?>" <?= $d['aktif'] ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>

            <?php if ($canEditKonten): ?>
            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan Dokumen</button>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
