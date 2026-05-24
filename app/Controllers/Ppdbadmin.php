<?php

namespace App\Controllers;

use App\Libraries\PpdbNotificationService;
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
    private PpdbNotificationService $notificationService;

    public function __construct()
    {
        $this->model = new PpdbModel();
        $this->notificationService = new PpdbNotificationService();
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
            'jalur_pendaftaran' => 'required|in_list[Afirmasi,Mutasi Kerja Orang Tua,Domisili]',
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
            'jalur_pendaftaran' => $this->request->getPost('jalur_pendaftaran'),
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
            'jalur_pendaftaran' => 'required|in_list[Afirmasi,Mutasi Kerja Orang Tua,Domisili]',
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
            'jalur_pendaftaran' => $this->request->getPost('jalur_pendaftaran'),
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

        if (! in_array($status, $allowed, true)) {
            return redirect()->to('/ppdb')
                ->with('error', 'Status tidak valid.');
        }

        $item = $this->model->find($id);
        if (! $item) {
            return redirect()->to('/ppdb')
                ->with('error', 'Data tidak ditemukan.');
        }

        $this->model->update($id, ['status' => $status]);

        $message = "Status pendaftar diubah ke: <strong>{$status}</strong>";

        if (in_array($status, ['Diterima', 'Ditolak'], true)) {
            $notification = $this->notificationService->sendStatusNotification($item, $status);

            if ($notification['email_sent']) {
                $message .= " dan notifikasi email berhasil dikirim ke <strong>{$item['email']}</strong>.";
            } else {
                $err = $notification['errors'][0] ?? 'Kesalahan tidak diketahui';
                $message .= ", namun <span class='text-danger'>email gagal: {$err}</span>.";
            }
        }

        return redirect()->to('/ppdb')->with('success', $message);
    }

    public function hapus(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * Menampilkan laporan PPDB tahunan.
     */
    public function report(?int $year = null): string
    {
        $year = $year ?? (int) date('Y');

        return $this->render('pages/ppdb/yearly_report', [
            'title'     => "Laporan PPDB Tahun $year",
            'page_icon' => '📈',
            'year'      => $year,
            'list'      => $this->model->getDataByYear($year),
            'summary'   => $this->model->getYearlySummary($year),
            'available_years' => $this->getAvailablePpdbYears(),
        ]);
    }

    /**
     * Cetak Laporan PPDB Tahunan (Format PDF via Browser Print)
     */
    public function printYearlyReport(?int $year = null)
    {
        $year = $year ?? (int) date('Y');

        return view('pages/ppdb/report_pdf', [
            'year'      => $year,
            'list'      => $this->model->getDataByYear($year),
            'summary'   => $this->model->getYearlySummary($year),
            'logo_url'  => $this->data['logo_url'],
        ]);
    }

    /**
     * Mengambil daftar tahun pendaftaran yang tersedia di database.
     */
    private function getAvailablePpdbYears(): array
    {
        $years = $this->model->select("DISTINCT YEAR(tgl_daftar) as year")
                            ->orderBy('year', 'DESC')
                            ->findAll();
        return array_column($years, 'year') ?: [(int)date('Y')];
    }

    /**
     * Menampilkan daftar laporan tahunan yang sudah disimpan
     */
    public function daftarLaporan(): string
    {
        $laporanModel = new \App\Models\LaporanTahunanPpdbModel();
        
        return $this->render('pages/ppdb/daftar_laporan', [
            'title'     => 'Daftar Laporan Tahunan PPDB',
            'page_icon' => '📋',
            'laporan'   => $laporanModel->orderBy('tahun', 'DESC')->findAll(),
        ]);
    }

    /**
     * Menyimpan laporan tahunan ke database (Auto-generate)
     * Endpoint: POST /ppdb/simpan-laporan atau GET /ppdb/simpan-laporan/{tahun}
     */
    public function simpanLaporan(?int $tahun = null)
    {
        if (!hasPermission('ppdb_laporan', 'create')) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk menyimpan laporan.');
        }

        // Ambil tahun dari POST parameter jika ada, atau dari URL segment
        $tahun = $this->request->getPost('tahun') ?: $tahun;
        $tahun = $tahun ?? (int)date('Y');
        $tahun = (int)$tahun;

        if ($tahun < 2000 || $tahun > 2099) {
            return redirect()->back()
                ->with('error', 'Tahun tidak valid. Silakan pilih tahun yang benar.');
        }

        $userId = session()->get('user_id') ?? 0;

        $laporanModel = new \App\Models\LaporanTahunanPpdbModel();
        
        // Cek apakah laporan untuk tahun ini sudah ada
        $existing = $laporanModel->where('tahun', $tahun)->first();
        if ($existing) {
            return redirect()->back()
                ->with('warning', "Laporan tahunan untuk tahun $tahun sudah ada. Silakan edit yang sudah ada.");
        }

        // Generate laporan
        $catatan = trim($this->request->getPost('catatan') ?? '');
        $laporanModel->generateLaporan($tahun, $userId, $catatan, 'Draft');

        return redirect()->to('/ppdb/laporan')
            ->with('success', "Laporan tahunan PPDB tahun $tahun berhasil disimpan sebagai Draft.");
    }

    /**
     * Finalisasi laporan (ubah status dari Draft ke Final)
     */
    public function finalisasiLaporan(int $id)
    {
        if (!hasPermission('ppdb_laporan', 'edit')) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk finalisasi laporan.');
        }

        $laporanModel = new \App\Models\LaporanTahunanPpdbModel();
        $laporan = $laporanModel->find($id);

        if (!$laporan) {
            return redirect()->back()
                ->with('error', 'Laporan tidak ditemukan.');
        }

        $laporanModel->finalisasi($id);

        return redirect()->back()
            ->with('success', "Laporan tahunan tahun {$laporan['tahun']} berhasil difinalisasi.");
    }

    /**
     * Arsipkan laporan
     */
    public function arsipkanLaporan(int $id)
    {
        if (!hasPermission('ppdb_laporan', 'delete')) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengarsipkan laporan.');
        }

        $laporanModel = new \App\Models\LaporanTahunanPpdbModel();
        $laporan = $laporanModel->find($id);

        if (!$laporan) {
            return redirect()->back()
                ->with('error', 'Laporan tidak ditemukan.');
        }

        $laporanModel->arsipkan($id);

        return redirect()->back()
            ->with('success', "Laporan tahunan tahun {$laporan['tahun']} berhasil diarsipkan.");
    }

    /**
     * Menampilkan detail laporan tahunan
     */
    public function detailLaporan(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $laporanModel = new \App\Models\LaporanTahunanPpdbModel();
        $laporan = $laporanModel->find($id);

        if (!$laporan) {
            return redirect()->to('/ppdb/laporan')
                ->with('error', 'Laporan tidak ditemukan.');
        }

        return $this->render('pages/ppdb/detail_laporan', [
            'title'     => "Laporan Tahunan PPDB {$laporan['tahun_ajaran']}",
            'page_icon' => '📊',
            'laporan'   => $laporan,
        ]);
    }

    /**
     * Melayani request file upload PPDB agar tidak 404 saat dibuka di Admin
     */
    public function serveFile(string $filename)
    {
        $path = $this->data['public_uploads_path'] . 'ppdb/' . $filename;

        if (! is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("File $filename tidak ditemukan.");
        }

        // Tampilkan file (gambar/pdf) langsung di browser
        return $this->response->download($path, null)->inline();
    }

    /**
     * Export data PPDB ke format CSV
     */
    public function export(?int $id = null, ?int $year = null)
    {
        // Handle route /ppdb/export/0/(:num) - when URL is /ppdb/export/0/2024
        // In this case, $id will be the year number, so we need to check
        $segments = service('uri')->getSegments();
        if (isset($segments[2]) && $segments[2] === '0' && isset($segments[3])) {
            // URL is /ppdb/export/0/YEAR - swap parameters
            $year = $id;
            $id = 0;
        }

        if ($id && $id > 0) {
            $data = $this->model->where('id_ppdb', $id)->findAll();
            $filename = 'Detail_PPDB_' . url_title($data[0]['nama'] ?? 'Siswa', '_', true) . '_' . date('Ymd') . '.xls';
        } elseif ($year) {
            $data = $this->model->getDataByYear($year);
            $filename = 'Laporan_PPDB_' . $year . '_' . date('Ymd_His') . '.xls';
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
                <td colspan="24" class="center" style="border:none;">Laporan Tahun: <?= $year ?? 'Semua' ?> | Tanggal Ekspor: <?= date('d/m/Y H:i') ?></td>
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
                    <th>Jalur Pendaftaran</th>
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
                    <td class="center"><?= (int) $row['id_ppdb'] ?></td>
                    <td><?= esc((string) ($row['nama'] ?? '')) ?></td>
                    <td class="text"><?= esc((string) ($row['nik_siswa'] ?? '')) ?></td>
                    <td class="text"><?= esc((string) ($row['nisn'] ?: '-')) ?></td>
                    <td class="center"><?= (($row['jenis_kelamin'] ?? '') === 'Laki-laki') ? 'L' : 'P' ?></td>
                    <td><?= esc((string) ($row['agama'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['tempat_lahir'] ?? '')) ?></td>
                    <td><?= ! empty($row['tgl_lahir']) ? date('d/m/Y', strtotime((string) $row['tgl_lahir'])) : '-' ?></td>
                    <td class="center"><?= esc((string) ($row['usia'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['nama_ortu'] ?? '')) ?></td>
                    <td class="text"><?= esc((string) ($row['telepon'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['email'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['alamat'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['asal'] ?? '')) ?></td>
                    <td><?= esc((string) ($row['jalur_pendaftaran'] ?? '')) ?></td>
                    <td class="center"><?= esc(strtoupper((string) ($row['status'] ?? ''))) ?></td>
                    <td><?= ! empty($row['tgl_daftar']) ? date('d/m/Y', strtotime((string) $row['tgl_daftar'])) : '-' ?></td>
                    
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
