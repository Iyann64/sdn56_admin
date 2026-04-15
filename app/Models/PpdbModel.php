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
        'nama', 'tempat_lahir', 'tgl_lahir',
        'nama_ortu', 'telepon', 'email',
        'asal', 'usia', 'status', 'tgl_daftar', 'catatan',
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
}