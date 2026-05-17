<?php

namespace App\Models;

use CodeIgniter\Model;

class PpdbJadwalModel extends Model
{
    protected $table            = 'ppdb_jadwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['jalur', 'tgl_mulai', 'tgl_akhir', 'keterangan', 'aktif'];

    public function getJadwalAktif()
    {
        return $this->where('aktif', 1)->findAll();
    }
}