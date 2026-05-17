<?php

namespace App\Models;

use CodeIgniter\Model;

class PpdbConfigModel extends Model
{
    protected $table            = 'ppdb_config';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'status', 'tgl_buka', 'tgl_tutup', 'kuota', 
        'kuota_afirmasi', 'kuota_mutasi', 'kuota_domisili', 
        'usia_min', 'usia_max'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = ''; // Kita hanya butuh updated_at
    protected $updatedField     = 'updated_at';

    public function getConfig()
    {
        return $this->find(1);
    }
}