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
            'foto'     => 'uploaded[foto]|max_size[foto,51200]|ext_in[foto,jpg,jpeg,png,webp,mp4,webm,mov]', // Max 50MB
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/galeri')
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }
        $namaFile = null;
        $file     = $this->request->getFile('foto');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $namaFile = $file->getRandomName();
            // Pindahkan file ke folder uploads/galeri di proyek web publik
            $file->move($this->data['public_uploads_path'] . 'galeri', $namaFile);
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

    public function update(int $id)
    {
        $rules = [
            'nama'     => 'required|min_length[3]|max_length[200]',
            'kategori' => 'required',
            'foto'     => 'permit_empty|max_size[foto,51200]|ext_in[foto,jpg,jpeg,png,webp,mp4,webm,mov]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/galeri')
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/galeri')->with('error', 'Data tidak ditemukan.');
        }

        $namaFile = $item['file_foto'];
        $file     = $this->request->getFile('foto');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            // Hapus file lama dari folder publik jika ada
            if (!empty($namaFile)) {
                $oldPath = $this->data['public_uploads_path'] . 'galeri/' . $namaFile;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            $namaFile = $file->getRandomName();
            // Pindahkan file ke folder uploads/galeri di proyek web publik
            $file->move($this->data['public_uploads_path'] . 'galeri', $namaFile);
        }

        $this->model->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'kategori'  => $this->request->getPost('kategori'),
            'emoji'     => $this->request->getPost('emoji') ?: '🖼️',
            'file_foto' => $namaFile,
        ]);

        return redirect()->to('/galeri')
            ->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function hapus(int $id)
    {
        $item = $this->model->find($id);

        if ($item && ! empty($item['file_foto'])) {
            $filePath = $this->data['public_uploads_path'] . 'galeri/' . $item['file_foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/galeri')
            ->with('success', 'Foto berhasil dihapus.');
    }
}