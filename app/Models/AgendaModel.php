<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * AgendaModel — sdn56_admin
 * Tabel: agenda
 */
class AgendaModel extends Model
{
    protected $table          = 'agenda';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'judul', 'tanggal', 'waktu', 'tempat',
        'deskripsi', 'kategori', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    // ── Agenda aktif yang belum lewat ─────────────────────────

    public function getAktif(int $limit = 5): array
    {
        return $this->where('status', 'Aktif')
                    ->where('tanggal >=', date('Y-m-d'))
                    ->orderBy('tanggal', 'ASC')
                    ->limit($limit)->findAll();
    }

    // ── Agenda berdasarkan bulan (Y-m) ────────────────────────

    public function getByBulan(?string $bulan = null): array
    {
        $bulan = $bulan ?? date('Y-m');
        [$year, $month] = explode('-', $bulan);

        return $this->where("YEAR(tanggal)",  (int) $year)
                    ->where("MONTH(tanggal)", (int) $month)
                    ->orderBy('tanggal', 'ASC')
                    ->orderBy('waktu',   'ASC')
                    ->findAll();
    }
}