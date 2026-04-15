<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * GaleriModel — sdn56_admin
 * Tabel: galeri
 */
class GaleriModel extends Model
{
    protected $table          = 'galeri';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'nama', 'kategori', 'emoji', 'file_foto',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    public function getFeatured(int $limit = 7): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)->findAll();
    }

    public function getAll(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getKategori(): array
    {
        $rows = $this->select('kategori')->distinct()
                    ->orderBy('kategori', 'ASC')->findAll();
        return array_column($rows, 'kategori');
    }
}