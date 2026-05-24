<?php

namespace App\Models;

use CodeIgniter\Model;

class PpdbDokumenModel extends Model
{
    protected $table            = 'ppdb_dokumen';
    protected $primaryKey       = 'id_ppdb_dokumen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'deskripsi', 'wajib', 'aktif'];

    public function getWajib()
    {
        return $this->where('wajib', 1)->where('aktif', 1)->findAll();
    }
}
