<?php

namespace App\Controllers;

use App\Models\AgendaModel;

/**
 * AgendaAdmin Controller — sdn56_admin
 * CRUD Agenda & Kalender Kegiatan
 *
 * GET  /agenda                → index()
 * GET  /agenda/tambah         → tambah()
 * POST /agenda/simpan         → simpan()
 * GET  /agenda/edit/:id       → edit()
 * POST /agenda/update/:id     → update()
 * GET  /agenda/hapus/:id      → hapus()
 */
class AgendaAdmin extends BaseController
{
    private AgendaModel $model;

    public function __construct()
    {
        $this->model = new AgendaModel();
    }

    public function index(): string
    {
        return $this->render('pages/agenda/index', [
            'title'     => 'Agenda & Kegiatan',
            'page_icon' => '📅',
            'list'      => $this->model->orderBy('tanggal', 'ASC')->findAll(),
        ]);
    }

    public function tambah(): string
    {
        return $this->render('pages/agenda/form', [
            'title'     => 'Tambah Agenda',
            'page_icon' => '➕',
        ]);
    }

    public function simpan()
    {
        $rules = [
            'judul'   => 'required|min_length[3]|max_length[255]',
            'tanggal' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/agenda/tambah')
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->insert([
            'judul'    => $this->request->getPost('judul'),
            'tanggal'  => $this->request->getPost('tanggal'),
            'waktu'    => $this->request->getPost('waktu') ?: null,
            'tempat'   => $this->request->getPost('tempat'),
            'kategori' => $this->request->getPost('kategori') ?: 'Lainnya',
            'status'   => 'Aktif',
        ]);

        return redirect()->to('/agenda')
            ->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $item = $this->model->find($id);

        if (! $item) {
            return redirect()->to('/agenda')
                ->with('error', 'Agenda tidak ditemukan.');
        }

        return $this->render('pages/agenda/form', [
            'title'     => 'Edit Agenda',
            'page_icon' => '✏️',
            'item'      => $item,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'judul'   => 'required|min_length[3]|max_length[255]',
            'tanggal' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to("/agenda/edit/$id")
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->update($id, [
            'judul'    => $this->request->getPost('judul'),
            'tanggal'  => $this->request->getPost('tanggal'),
            'waktu'    => $this->request->getPost('waktu') ?: null,
            'tempat'   => $this->request->getPost('tempat'),
            'kategori' => $this->request->getPost('kategori'),
            'status'   => $this->request->getPost('status') ?: 'Aktif',
        ]);

        return redirect()->to('/agenda')
            ->with('success', 'Agenda berhasil diperbarui!');
    }

    public function hapus(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/agenda')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}