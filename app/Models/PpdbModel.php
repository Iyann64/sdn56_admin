<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * PpdbModel — sdn56_admin
 * Tabel: ppdb
 */
class PpdbModel extends Model
{
    protected $table          = 'ppdb';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'nama', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'agama', 'nik_siswa', 'nisn',
        'nama_ortu', 'nik_ortu', 'telepon', 'email', 'alamat', 'kode_pos', 'hubungan', 
        'pekerjaan_ortu', 'agama_ortu', 'kewarganegaraan', 'status_kesehatan',
        'asal', 'jalur_pendaftaran', 'usia', 'status', 'tgl_daftar', 'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    // ── Hitung jumlah per status ──────────────────────────────

    public function hitungByStatus(): array
    {
        $rows   = $this->select('status, COUNT(*) as total')
                        ->groupBy('status')
                        ->findAll();
        $result = ['Menunggu' => 0, 'Diterima' => 0, 'Ditolak' => 0, 'total' => 0];

        foreach ($rows as $row) {
            $result[$row['status']] = (int) $row['total'];
        }

        $result['total'] = $result['Menunggu'] + $result['Diterima'] + $result['Ditolak'];
        return $result;
    }

    // ── Cek duplikat email per tahun ──────────────────────────

    public function sudahDaftar(string $email, string $tahun): bool
    {
        return $this->where('email', $email)
                    ->where("YEAR(tgl_daftar)", (int) $tahun)
                    ->first() !== null;
    }

    // ── Ambil pendaftar terbaru ───────────────────────────────

    public function getTerbaru(int $limit = 5): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)->findAll();
    }

    // ── Ambil berdasarkan status ──────────────────────────────

    public function getByStatus(string $status): array
    {
        return $this->where('status', $status)
                    ->orderBy('tgl_daftar', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil semua data pendaftar untuk tahun tertentu.
     */
    public function getDataByYear(int $year): array
    {
        return $this->where("YEAR(tgl_daftar)", $year)
                    ->orderBy('tgl_daftar', 'ASC')
                    ->findAll();
    }

    /**
     * Menghitung ringkasan statistik PPDB untuk tahun tertentu.
     */
    public function getYearlySummary(int $year): array
    {
        $summary = [
            'total'     => 0,
            'Diterima'  => 0,
            'Menunggu'  => 0,
            'Ditolak'   => 0,
            'laki_laki' => 0,
            'perempuan' => 0,
            'monthly'   => array_fill(1, 12, 0),
        ];

        $data = $this->select('status, jenis_kelamin, MONTH(tgl_daftar) as month')
                     ->where("YEAR(tgl_daftar)", $year)
                     ->findAll();

        foreach ($data as $row) {
            $summary['total']++;
            
            if (isset($summary[$row['status']])) {
                $summary[$row['status']]++;
            }

            if ($row['jenis_kelamin'] === 'Laki-laki') {
                $summary['laki_laki']++;
            } elseif ($row['jenis_kelamin'] === 'Perempuan') {
                $summary['perempuan']++;
            }

            $m = (int)$row['month'];
            if ($m >= 1 && $m <= 12) {
                $summary['monthly'][$m]++;
            }
        }

        return $summary;
    }

    /**
     * Ambil daftar tahun yang tersedia di data PPDB
     */
    public function getAvailableYears(): array
    {
        $rows = $this->select('DISTINCT YEAR(tgl_daftar) as tahun')
                     ->orderBy('tahun', 'DESC')
                     ->findAll();
        
        $years = [];
        foreach ($rows as $row) {
            if ($row['tahun']) {
                $years[] = (int)$row['tahun'];
            }
        }

        // Jika kosong, tambahkan tahun saat ini
        if (empty($years)) {
            $years[] = (int)date('Y');
        }

        return array_values(array_unique($years));
    }
}