<?php

namespace App\Controllers;

use App\Models\PpdbModel;

/**
 * PpdbAdmin Controller — sdn56_admin
 * Manajemen data pendaftar PPDB
 *
 * GET  /ppdb                        → index()
 * GET  /ppdb/tambah                 → tambah()
 * POST /ppdb/simpan                 → simpan()
 * GET  /ppdb/status/:id/:status     → ubahStatus()
 * GET  /ppdb/hapus/:id              → hapus()
 */
class PpdbAdmin extends BaseController
{
    private PpdbModel $model;

    public function __construct()
    {
        $this->model = new PpdbModel();
    }

    public function index(): string
    {
        return $this->render('pages/ppdb/index', [
            'title'     => 'Data PPDB',
            'page_icon' => '✏️',
            'list'      => $this->model->orderBy('tgl_daftar', 'DESC')->findAll(),
            'summary'   => $this->model->hitungByStatus(),
        ]);
    }

    public function tambah(): string
    {
        return $this->render('pages/ppdb/form', [
            'title'     => 'Tambah Pendaftar',
            'page_icon' => '➕',
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama'       => 'required|min_length[3]|max_length[150]',
            'tgl_daftar' => 'required|valid_date[Y-m-d]',
            'telepon'    => 'permit_empty|min_length[9]|max_length[20]',
            'email'      => 'permit_empty|valid_email',
            'usia'       => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/ppdb/tambah')
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $this->model->insert([
            'nama'         => $this->request->getPost('nama'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'    => $this->request->getPost('tgl_lahir') ?: null,
            'nama_ortu'    => $this->request->getPost('nama_ortu'),
            'telepon'      => $this->request->getPost('telepon'),
            'email'        => $this->request->getPost('email'),
            'asal'         => $this->request->getPost('asal') ?: '-',
            'usia'         => (int) $this->request->getPost('usia'),
            'status'       => $this->request->getPost('status') ?: 'Menunggu',
            'tgl_daftar'   => $this->request->getPost('tgl_daftar'),
        ]);

        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil ditambahkan!');
    }

    public function ubahStatus(int $id, string $status)
    {
        $allowed = ['Diterima', 'Menunggu', 'Ditolak'];

        if (! in_array($status, $allowed)) {
            return redirect()->to('/ppdb')
                ->with('error', 'Status tidak valid.');
        }

        $this->model->update($id, ['status' => $status]);

        return redirect()->to('/ppdb')
            ->with('success', "Status pendaftar diubah ke: <strong>$status</strong>");
    }

    public function hapus(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/ppdb')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }
}