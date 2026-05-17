<div class="card">
    <div class="card-header">
        <div class="card-title">📄 Manajemen Dokumen Persyaratan</div>
    </div>
    <div class="card-body">
        <p style="margin-bottom: 20px; font-size: 14px; color: var(--gray);">
            Tentukan dokumen apa saja yang harus disiapkan oleh wali murid. Pengaturan "Wajib" akan memberikan tanda bintang pada formulir dan daftar ceklis di PDF.
        </p>
        
        <form action="<?= base_url('ppdb/persyaratan/simpan') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th width="250">Nama Dokumen</th>
                            <th>Keterangan / Deskripsi</th>
                            <th style="text-align:center">Wajib</th>
                            <th style="text-align:center">Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dokumen as $d): ?>
                        <input type="hidden" name="id[]" value="<?= $d['id'] ?>">
                        <tr>
                            <td>
                                <input type="text" name="nama[<?= $d['id'] ?>]" 
                                       value="<?= esc($d['nama']) ?>" class="form-control" style="font-weight:700">
                            </td>
                            <td>
                                <input type="text" name="keterangan[<?= $d['id'] ?>]" 
                                       value="<?= esc($d['keterangan'] ?? '') ?>" class="form-control" placeholder="Contoh: Format PDF/JPG, maksimal 2MB">
                            </td>
                            <td style="text-align:center">
                                <label class="switch">
                                    <input type="checkbox" name="wajib[]" value="<?= $d['id'] ?>" <?= $d['wajib'] ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td style="text-align:center">
                                <label class="switch">
                                    <input type="checkbox" name="aktif[]" value="<?= $d['id'] ?>" <?= $d['aktif'] ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan Dokumen</button>
            </div>
        </form>
    </div>
</div>