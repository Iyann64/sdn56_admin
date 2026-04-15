<?php

namespace App\Controllers;

use App\Models\GaleriModel;

/**
 * GaleriAdmin Controller — sdn56_admin
 * Manajemen Galeri Foto
 *
 * GET  /galeri             → index()
 * POST /galeri/upload      → upload()
 * GET  /galeri/hapus/:id   → hapus()
 */
class GaleriAdmin extends BaseController
{
    private GaleriModel $model;

    public function __construct()
    {
        $this->model = new GaleriModel();
    }

    public function index(): string
    {
        return $this->render('pages/galeri/index', [
            'title'     => 'Galeri Foto',
            'page_icon' => '🖼️',
            'list'      => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function upload()
    {
        $rules = [
            'nama'     => 'required|min_length[3]|max_length[200]',
            'kategori' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/galeri')
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $namaFile = null;
        $file     = $this->request->getFile('foto');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            // Validasi file gambar
            if (! $this->validate(['foto' => 'is_image[foto]|max_size[foto,5120]'])) {
                return redirect()->to('/galeri')
                    ->with('error', 'File tidak valid. Gunakan JPG/PNG/WEBP maks 5MB.');
            }

            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $namaFile);
        }

        $this->model->insert([
            'nama'      => $this->request->getPost('nama'),
            'kategori'  => $this->request->getPost('kategori'),
            'emoji'     => $this->request->getPost('emoji') ?: '🖼️',
            'file_foto' => $namaFile,
        ]);

        return redirect()->to('/galeri')
            ->with('success', 'Foto berhasil ditambahkan!');
    }

    public function hapus(int $id)
    {
        $item = $this->model->find($id);

        if ($item && ! empty($item['file_foto'])) {
            $filePath = FCPATH . 'uploads/' . $item['file_foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/galeri')
            ->with('success', 'Foto berhasil dihapus.');
    }
}