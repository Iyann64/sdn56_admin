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

    public function getConfig(): array
    {
        $rows = $this->findAll();
        $config = [];

        foreach ($rows as $row) {
            $config[$row['kunci']] = $row['nilai'];
        }

        return $config;
    }

    public function saveConfigValue(string $key, mixed $value, string $type = 'string', ?string $description = null): void
    {
        $payload = [
            'kunci'     => $key,
            'nilai'     => is_bool($value) ? ($value ? '1' : '0') : (string) $value,
            'tipe'      => $type,
            'deskripsi' => $description,
        ];

        $existing = $this->where('kunci', $key)->first();

        if ($existing) {
            $this->update($existing[$this->primaryKey], $payload);
            return;
        }

        $this->insert($payload);
    }
}
