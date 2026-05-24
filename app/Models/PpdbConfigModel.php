<?php

namespace App\Models;

use CodeIgniter\Model;

class PpdbConfigModel extends Model
{
    protected $table            = 'ppdb_config';
    protected $primaryKey       = 'id_ppdb_config';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kunci', 'nilai', 'tipe', 'deskripsi'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getConfig()
    {
        $rows = $this->findAll();
        $config = [];

        foreach ($rows as $row) {
            $config[$row['kunci']] = $row['nilai'];
        }

        return $config;
    }
}
