<?php

namespace App\Controllers;

use App\Models\PpdbDokumenModel;

class PpdbPersyaratan extends BaseController
{
    protected $dokumenModel;

    public function __construct()
    {
        $this->dokumenModel = new PpdbDokumenModel();
    }

    public function index()
    {
        return $this->render('pages/ppdb/persyaratan', [
            'title'     => 'Syarat Dokumen',
            'page_icon' => '📄',
            'dokumen'   => $this->dokumenModel->findAll(),
        ]);
    }

    public function simpan()
    {
        $ids = (array) ($this->request->getPost('id') ?? []);
        $nama = (array) ($this->request->getPost('nama') ?? []);
        $deskripsi = (array) ($this->request->getPost('deskripsi') ?? []);
        $wajib = $this->request->getPost('wajib') ?? [];
        $aktif = $this->request->getPost('aktif') ?? [];

        foreach ($ids as $id) {
            $this->dokumenModel->update($id, [
                'nama'       => isset($nama[$id]) ? $nama[$id] : '',
                'deskripsi'  => isset($deskripsi[$id]) ? $deskripsi[$id] : '',
                'wajib'      => in_array($id, $wajib) ? 1 : 0,
                'aktif'      => in_array($id, $aktif) ? 1 : 0
            ]);
        }

        return redirect()->to('/ppdb/persyaratan')->with('success', 'Persyaratan dokumen berhasil diperbarui.');
    }
}
