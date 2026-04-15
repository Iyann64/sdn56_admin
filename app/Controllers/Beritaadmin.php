<?php

namespace App\Controllers;

use App\Models\BeritaModel;

/**
 * BeritaAdmin Controller — sdn56_admin
 * CRUD Berita & Kegiatan
 *
 * GET  /berita                → index()
 * GET  /berita/tambah         → tambah()
 * POST /berita/simpan         → simpan()
 * GET  /berita/edit/:id       → edit()
 * POST /berita/update/:id     → update()
 * GET  /berita/hapus/:id      → hapus()
 */
class BeritaAdmin extends BaseController
{
    private BeritaModel $model;

    public function __construct()
    {
        $this->model = new BeritaModel();
    }

    public function index(): string
    {
        return $this->render('pages/berita/index', [
            'title'       => 'Manajemen Berita',
            'page_icon'   => '📰',
            'berita_list' => $this->model->orderBy('tanggal', 'DESC')->findAll(),
        ]);
    }

    public function tambah(): string
    {
        return $this->render('pages/berita/form', [
            'title'     => 'Tambah Berita',
            'page_icon' => '📝',
        ]);
    }

    public function simpan()
    {
        $rules = [
            'judul'    => 'required|min_length[5]|max_length[255]',
            'kategori' => 'required',
            'tanggal'  => 'required|valid_date[Y-m-d]',
            'isi'      => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/berita/tambah')
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $judul = $this->request->getPost('judul');

        $this->model->insert([
            'judul'    => $judul,
            'slug'     => $this->model->buatSlug($judul),
            'kategori' => $this->request->getPost('kategori'),
            'status'   => $this->request->getPost('status') ?: 'Draf',
            'tanggal'  => $this->request->getPost('tanggal'),
            'isi'      => $this->request->getPost('isi'),
            'views'    => 0,
        ]);

        return redirect()->to('/berita')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $berita = $this->model->find($id);

        if (! $berita) {
            return redirect()->to('/berita')
                ->with('error', 'Berita tidak ditemukan.');
        }

        return $this->render('pages/berita/form', [
            'title'     => 'Edit Berita',
            'page_icon' => '✏️',
            'berita'    => $berita,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'judul'   => 'required|min_length[5]|max_length[255]',
            'tanggal' => 'required|valid_date[Y-m-d]',
            'isi'     => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to("/berita/edit/$id")
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $judul = $this->request->getPost('judul');

        $this->model->update($id, [
            'judul'    => $judul,
            'slug'     => $this->model->buatSlug($judul),
            'kategori' => $this->request->getPost('kategori'),
            'status'   => $this->request->getPost('status'),
            'tanggal'  => $this->request->getPost('tanggal'),
            'isi'      => $this->request->getPost('isi'),
        ]);

        return redirect()->to('/berita')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function hapus(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/berita')
            ->with('success', 'Berita berhasil dihapus.');
    }
}