<?php

namespace App\Controllers;

use App\Models\PpdbModel;

/**
 * PpdbAdmin Controller — sdn56_admin
 * Manajemen data pendaftar PPDB
 *
 * GET  /ppdb                        → index()
 * GET  /ppdb/tambah                 → tambah()
 * POST /ppdb/simpan                 → simpan()
 * GET  /ppdb/status/:id/:status     → ubahStatus()
 * GET  /ppdb/hapus/:id              → hapus()
 */
class PpdbAdmin extends BaseController
{
    private PpdbModel $model;

    public function __construct()
    {
        $this->model = new PpdbModel();
    }

    public function index(): string
    {
        return $this->render('pages/ppdb/index', [
            'title'     => 'Data PPDB',
            'page_icon' => '✏️',
            'list'      => $this->model->orderBy('tgl_daftar', 'DESC')->findAll(),
            'summary'   => $this->model->hitungByStatus(),
        ]);
    }

    public function detail(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $item = $this->model->find($id);

        if (! $item) {
            return redirect()->to('/ppdb')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        }

        return $this->render('pages/ppdb/detail', [
            'title'     => 'Detail Pendaftar',
            'page_icon' => '👤',
            'item'      => $item,
        ]);
    }

    public function tambah(): string
    {
        return $this->render('pages/ppdb/form', [
            'title'     => 'Tambah Pendaftar',
            'page_icon' => '➕',
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama_lengkap'    => 'required|min_length[3]|max_length[150]',
            'nik_siswa'       => 'required|exact_length[16]|numeric',
            'jenis_kelamin'   => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir'    => 'required',
            'tgl_lahir'       => 'required|valid_date[Y-m-d]',
            'agama'           => 'required',
            'nama_ortu'       => 'required|min_length[3]|max_length[150]',
            'nik_ortu'        => 'required|exact_length[16]|numeric',
            'telepon'         => 'required|min_length[9]|max_length[20]',
            'email'           => 'required|valid_email',
            'alamat'          => 'required',
            'tgl_daftar'      => 'required|valid_date[Y-m-d]',
            'usia'            => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/ppdb/tambah')
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->insert([
            'nama'         => $this->request->getPost('nama_lengkap'),
            'nik_siswa'    => $this->request->getPost('nik_siswa'),
            'nisn'         => $this->request->getPost('nisn'),
            'jenis_kelamin'=> $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'    => $this->request->getPost('tgl_lahir') ?: null,
            'agama'        => $this->request->getPost('agama'),
            'usia'         => $this->request->getPost('usia') ?: null,
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'status_kesehatan'=> $this->request->getPost('status_kesehatan'),
            'nama_ortu'    => $this->request->getPost('nama_ortu'),
            'nik_ortu'     => $this->request->getPost('nik_ortu'),
            'pekerjaan_ortu'  => $this->request->getPost('pekerjaan_ortu'),
            'agama_ortu'   => $this->request->getPost('agama_ortu'),
            'hubungan'     => $this->request->getPost('hubungan'),
            'telepon'      => $this->request->getPost('telepon'),
            'email'        => $this->request->getPost('email'),
            'alamat'       => $this->request->getPost('alamat'),
            'kode_pos'     => $this->request->getPost('kode_pos'),
            'asal'         => $this->request->getPost('asal_sekolah') ?: '-',
            'status'       => $this->request->getPost('status') ?: 'Menunggu',
            'tgl_daftar'   => $this->request->getPost('tgl_daftar'),
            'catatan'      => $this->request->getPost('catatan'),
        ]);

        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil ditambahkan!');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $item = $this->model->find($id);

        if (! $item) {
            return redirect()->to('/ppdb')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        }

        return $this->render('pages/ppdb/form', [
            'title'     => 'Edit Pendaftar',
            'page_icon' => '✏️',
            'item'      => $item,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'nama_lengkap'    => 'required|min_length[3]|max_length[150]',
            'nik_siswa'       => 'required|exact_length[16]|numeric',
            'jenis_kelamin'   => 'required|in_list[Laki-laki,Perempuan]',
            'tempat_lahir'    => 'required',
            'tgl_lahir'       => 'required|valid_date[Y-m-d]',
            'agama'           => 'required',
            'nama_ortu'       => 'required|min_length[3]|max_length[150]',
            'nik_ortu'        => 'required|exact_length[16]|numeric',
            'telepon'         => 'required|min_length[9]|max_length[20]',
            'email'           => 'required|valid_email',
            'alamat'          => 'required',
            'tgl_daftar'      => 'required|valid_date[Y-m-d]',
            'usia'            => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to("/ppdb/edit/$id")
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->update($id, [
            'nama'         => $this->request->getPost('nama_lengkap'),
            'nik_siswa'    => $this->request->getPost('nik_siswa'),
            'nisn'         => $this->request->getPost('nisn'),
            'jenis_kelamin'=> $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'    => $this->request->getPost('tgl_lahir') ?: null,
            'agama'        => $this->request->getPost('agama'),
            'usia'         => $this->request->getPost('usia') ?: null,
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'status_kesehatan'=> $this->request->getPost('status_kesehatan'),
            'nama_ortu'    => $this->request->getPost('nama_ortu'),
            'nik_ortu'     => $this->request->getPost('nik_ortu'),
            'pekerjaan_ortu'  => $this->request->getPost('pekerjaan_ortu'),
            'agama_ortu'   => $this->request->getPost('agama_ortu'),
            'hubungan'     => $this->request->getPost('hubungan'),
            'telepon'      => $this->request->getPost('telepon'),
            'email'        => $this->request->getPost('email'),
            'alamat'       => $this->request->getPost('alamat'),
            'kode_pos'     => $this->request->getPost('kode_pos'),
            'asal'         => $this->request->getPost('asal_sekolah') ?: '-',
            'status'       => $this->request->getPost('status'),
            'tgl_daftar'   => $this->request->getPost('tgl_daftar'),
            'catatan'      => $this->request->getPost('catatan'),
        ]);

        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil diperbarui!');
    }

    public function ubahStatus(int $id, string $status)
    {
        $allowed = ['Diterima', 'Menunggu', 'Ditolak'];

        if (! in_array($status, $allowed)) {
            return redirect()->to('/ppdb')
                ->with('error', 'Status tidak valid.');
        }

        $this->model->update($id, ['status' => $status]);

        return redirect()->to('/ppdb')
            ->with('success', "Status pendaftar diubah ke: <strong>$status</strong>");
    }

    public function hapus(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * Export data PPDB ke format CSV
     */
    public function export(?int $id = null)
    {
        if ($id) {
            $data = $this->model->where('id', $id)->findAll();
            $filename = 'Detail_PPDB_' . url_title($data[0]['nama'] ?? 'Siswa', '_', true) . '_' . date('Ymd') . '.xls';
        } else {
            $data = $this->model->orderBy('tgl_daftar', 'DESC')->findAll();
            $filename = 'Data_PPDB_SDN56_' . date('Y-m-d_His') . '.xls';
        }

        if (empty($data)) {
            return redirect()->to('/ppdb')->with('error', 'Tidak ada data untuk diekspor.');
        }

        // Konfigurasi Header HTTP untuk Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");

        // Generate output HTML Table yang akan dibaca sebagai Excel
        ?>
        <style>
            .header { background-color: #1a237e; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #000000; }
            .text { mso-number-format: "\@"; } /* Memaksa NIK/NISN agar tidak berubah jadi scientific notation */
            .center { text-align: center; border: 1px solid #000000; }
            .title { font-size: 18px; font-weight: bold; text-align: center; padding: 10px; }
            td { border: 1px solid #000000; padding: 5px; }
        </style>

        <table border="1">
            <tr>
                <td colspan="24" class="title">DATA PENDAFTARAN SISWA BARU (PPDB) SDN 56 PRABUMULIH</td>
            </tr>
            <tr>
                <td colspan="24" class="center" style="border:none;">Tanggal Ekspor: <?= date('d/m/Y H:i') ?></td>
            </tr>
            <tr></tr> <!-- Baris Kosong -->
            <thead>
                <tr class="header">
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIK Siswa</th>
                    <th>NISN</th>
                    <th>L/P</th>
                    <th>Agama</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Usia</th>
                    <th>Nama Ortu</th>
                    <th>Telepon/WA</th>
                    <th>Email</th>
                    <th>Alamat Lengkap</th>
                    <th>Asal Sekolah</th>
                    <th>Status</th>
                    <th>Tgl Daftar</th>
                    <th>Link Akta</th>
                    <th>Link KK</th>
                    <th>Link KTP</th>
                    <th>Link Foto</th>
                    <th>Link Imunisasi</th>
                    <th>Link Sehat</th>
                    <th>Link Ijazah</th>
                    <th>Link Pernyataan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td class="center"><?= $row['id'] ?></td>
                    <td><?= esc($row['nama']) ?></td>
                    <td class="text"><?= esc($row['nik_siswa']) ?></td>
                    <td class="text"><?= esc($row['nisn'] ?: '-') ?></td>
                    <td class="center"><?= $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></td>
                    <td><?= esc($row['agama']) ?></td>
                    <td><?= esc($row['tempat_lahir']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tgl_lahir'])) ?></td>
                    <td class="center"><?= $row['usia'] ?></td>
                    <td><?= esc($row['nama_ortu']) ?></td>
                    <td class="text"><?= esc($row['telepon']) ?></td>
                    <td><?= esc($row['email']) ?></td>
                    <td><?= esc($row['alamat']) ?></td>
                    <td><?= esc($row['asal']) ?></td>
                    <td class="center"><?= strtoupper($row['status']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tgl_daftar'])) ?></td>
                    
                    <!-- Link Dokumen -->
                    <?php 
                    $docs = ['file_akta', 'file_kk', 'file_ktp_ortu', 'file_foto_siswa', 'file_imunisasi', 'file_surat_sehat', 'file_ijazah_tk', 'file_pernyataan'];
                    foreach ($docs as $doc): 
                        if (!empty($row[$doc])): ?>
                            <td><a href="<?= $this->data['web_url'] . '/uploads/ppdb/' . $row[$doc] ?>">Lihat File</a></td>
                        <?php else: ?>
                            <td style="color: #ff0000;">Kosong</td>
                        <?php endif; 
                    endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        exit();
    }
}