<?php

namespace App\Controllers;

use App\Models\GuruModel;

/**
 * GuruAdmin Controller — sdn56_admin
 * CRUD Data Guru & Staf
 *
 * GET  /guru               → index()
 * GET  /guru/tambah        → tambah()
 * POST /guru/simpan        → simpan()
 * GET  /guru/edit/:id      → edit()
 * POST /guru/update/:id    → update()
 * GET  /guru/hapus/:id     → hapus()
 */
class GuruAdmin extends BaseController
{
    private GuruModel $model;

    public function __construct()
    {
        $this->model = new GuruModel();
    }

    public function index(): string
    {
        return $this->render('pages/guru/index', [
            'title'     => 'Guru & Staf',
            'page_icon' => '👨‍🏫',
            'list'      => $this->model->orderBy('jabatan', 'ASC')->findAll(),
        ]);
    }

    public function tambah(): string
    {
        return $this->render('pages/guru/form', [
            'title'     => 'Tambah Guru',
            'page_icon' => '➕',
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama'    => 'required|min_length[3]|max_length[150]',
            'nip'     => 'permit_empty|numeric|is_unique[guru.nip]',
            'jabatan' => 'required|max_length[100]',
        ];

        $messages = [
            'nip' => ['is_unique' => 'NIP ini sudah terdaftar.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->to('/guru/tambah')
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $data = [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'mapel'   => $this->request->getPost('mapel'),
            'status'  => $this->request->getPost('status') ?: 'Aktif',
            'avatar'  => $this->request->getPost('avatar') ?: '👨‍🏫',
        ];

        // Jika NIP diisi, gunakan NIP tersebut. 
        // Jika kosong, biarkan database memberikan nilai Auto Increment.
        $nipManual = $this->request->getPost('nip');
        if (!empty($nipManual)) {
            $data['nip'] = $nipManual;
        }

        $this->model->insert($data);

        return redirect()->to('/guru')
            ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit(string $nip): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $item = $this->model->find($nip);

        if (! $item) {
            return redirect()->to('/guru')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        return $this->render('pages/guru/form', [
            'title'     => 'Edit Guru',
            'page_icon' => '✏️',
            'item'      => $item,
        ]);
    }

    public function update(string $nip)
    {
        $rules = [
            'nama'    => 'required|min_length[3]|max_length[150]',
            'nip'     => "required|max_length[20]|is_unique[guru.nip,nip,$nip]",
            'jabatan' => 'required|max_length[100]',
        ];

        $messages = [
            'nip' => ['is_unique' => 'NIP ini sudah digunakan guru lain.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->to("/guru/edit/$nip")
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->update($nip, [
            'nama'    => $this->request->getPost('nama'),
            'nip'     => $this->request->getPost('nip'),
            'jabatan' => $this->request->getPost('jabatan'),
            'mapel'   => $this->request->getPost('mapel'),
            'status'  => $this->request->getPost('status'),
            'avatar'  => $this->request->getPost('avatar') ?: '👨‍🏫',
        ]);

        return redirect()->to('/guru')
            ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function hapus(string $nip)
    {
        $this->model->delete($nip);
        return redirect()->to('/guru')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}