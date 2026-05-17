<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * LaporanTahunanPpdbModel — sdn56_admin
 * Tabel: ppdb_laporan_tahunan
 * Model untuk mengelola laporan tahunan PPDB
 */
class LaporanTahunanPpdbModel extends Model
{
    protected $table          = 'ppdb_laporan_tahunan';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'tahun_ajaran',
        'tahun',
        'total_pendaftar',
        'total_diterima',
        'total_menunggu',
        'total_ditolak',
        'total_laki_laki',
        'total_perempuan',
        'rata_rata_usia',
        'catatan',
        'file_laporan',
        'dibuat_oleh',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    /**
     * Ambil laporan tahunan berdasarkan tahun ajaran
     * Format tahun ajaran: "2025/2026"
     */
    public function getByTahunAjaran(string $tahunAjaran)
    {
        return $this->where('tahun_ajaran', $tahunAjaran)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    /**
     * Ambil laporan tahunan berdasarkan tahun
     */
    public function getByTahun(int $tahun)
    {
        return $this->where('tahun', $tahun)
                    ->orderBy('tahun_ajaran', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil semua laporan status Final (sudah finalisasi)
     */
    public function getLaporanFinal()
    {
        return $this->where('status', 'Final')
                    ->orderBy('tahun', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil laporan berdasarkan user/pembuat
     */
    public function getByUser(int $userId)
    {
        return $this->where('dibuat_oleh', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Generate laporan tahunan otomatis dari data PPDB
     * Memasukkan data langsung dari tabel ppdb untuk tahun tertentu
     */
    public function generateLaporan(int $tahun, int $userId, string $catatan = '', string $status = 'Draft'): int
    {
        $ppdbModel = new PpdbModel();
        $summary = $ppdbModel->getYearlySummary($tahun);
        
        // Hitung rata-rata usia dengan proper alias
        $db = \Config\Database::connect();
        $avgResult = $db->table('ppdb')
                        ->select('AVG(usia) as rata_usia')
                        ->where('YEAR(tgl_daftar)', $tahun)
                        ->get()
                        ->getRowArray();
        
        $rataRataUsia = $avgResult && $avgResult['rata_usia'] 
                        ? (int)round((float)$avgResult['rata_usia']) 
                        : 0;

        // Tentukan tahun ajaran (asumsi tahun n/n+1)
        $tahunAjaran = ($tahun) . '/' . ($tahun + 1);

        $data = [
            'tahun_ajaran'     => $tahunAjaran,
            'tahun'            => $tahun,
            'total_pendaftar'  => $summary['total'] ?? 0,
            'total_diterima'   => $summary['Diterima'] ?? 0,
            'total_menunggu'   => $summary['Menunggu'] ?? 0,
            'total_ditolak'    => $summary['Ditolak'] ?? 0,
            'total_laki_laki'  => $summary['laki_laki'] ?? 0,
            'total_perempuan'  => $summary['perempuan'] ?? 0,
            'rata_rata_usia'   => $rataRataUsia,
            'catatan'          => $catatan,
            'dibuat_oleh'      => $userId,
            'status'           => $status,
        ];

        return $this->insert($data);
    }

    /**
     * Update status laporan ke Final (finalisasi)
     */
    public function finalisasi(int $id): bool
    {
        return $this->update($id, ['status' => 'Final']);
    }

    /**
     * Update status laporan ke Arsip
     */
    public function arsipkan(int $id): bool
    {
        return $this->update($id, ['status' => 'Arsip']);
    }

    /**
     * Hitung statistik total dari semua laporan
     */
    public function getStatistikGlobal(): array
    {
        $result = $this->select('
                COUNT(*) as total_laporan,
                SUM(total_pendaftar) as total_pendaftar_all,
                SUM(total_diterima) as total_diterima_all,
                AVG(rata_rata_usia) as rata_usia_all
            ')->first();

        return $result ?: [
            'total_laporan'      => 0,
            'total_pendaftar_all'=> 0,
            'total_diterima_all' => 0,
            'rata_usia_all'      => 0,
        ];
    }
}
