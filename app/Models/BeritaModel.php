<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * BeritaModel — sdn56_admin
 * Tabel: berita
 */
class BeritaModel extends Model
{
    protected $table          = 'berita';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields  = [
        'judul', 'slug', 'kategori', 'isi',
        'thumbnail', 'status', 'tanggal', 'views',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true; // validasi di Controller

    // ── Helpers publik (dipakai sdn56_web juga) ───────────────

    public function getTerbaru(int $limit = 5): array
    {
        return $this->where('status', 'Terbit')
                    ->orderBy('tanggal', 'DESC')
                    ->limit($limit)->findAll();
    }

    public function getPaged(int $perPage = 9, ?string $kategori = null): array
    {
        if ($kategori) $this->where('kategori', $kategori);
        return $this->where('status', 'Terbit')
                    ->orderBy('tanggal', 'DESC')
                    ->paginate($perPage);
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('status', 'Terbit')
                    ->first();
    }

    public function getTerkait(int $id, string $kategori, int $limit = 3): array
    {
        return $this->where('kategori', $kategori)
                    ->where('id !=', $id)
                    ->where('status', 'Terbit')
                    ->orderBy('tanggal', 'DESC')
                    ->limit($limit)->findAll();
    }

    public function tambahViews(int $id): void
    {
        $this->set('views', 'views + 1', false)
            ->where('id', $id)->update();
    }

    // ── Generate slug unik ────────────────────────────────────

    public function buatSlug(string $judul, int $excludeId = 0): string
    {
        $slug = url_title(strtolower($judul), '-', true);
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        $base = $slug;
        $i    = 1;

        while (true) {
            $existing = $this->where('slug', $slug);
            if ($excludeId > 0) $existing->where('id !=', $excludeId);
            if (! $existing->first()) break;
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}