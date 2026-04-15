<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table          = 'guru';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'nama', 'nip', 'jabatan', 'mapel', 'status', 'avatar',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    // ── Guru aktif (dipakai sdn56_web + dashboard) ────────────

    public function getAktif(): array
    {
        return $this->where('status', 'Aktif')
                    ->orderBy("FIELD(jabatan,'Kepala Sekolah')", 'DESC', false)
                    ->orderBy('jabatan', 'ASC')
                    ->orderBy('nama',    'ASC')
                    ->findAll();
    }

    // ── Jumlah guru aktif (untuk stat card) ──────────────────

    public function jumlahAktif(): int
    {
        return $this->where('status', 'Aktif')->countAllResults();
    }
}