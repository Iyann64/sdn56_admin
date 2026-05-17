<?php

namespace App\Controllers;

use App\Models\PpdbJadwalModel;

class PpdbJadwal extends BaseController
{
    protected $jadwalModel;

    public function __construct()
    {
        $this->jadwalModel = new PpdbJadwalModel();
    }

    public function index()
    {
        return $this->render('pages/ppdb/jadwal', [
            'title'     => 'Jadwal Per Jalur',
            'page_icon' => '📅',
            'jadwal'    => $this->jadwalModel->findAll(),
        ]);
    }

    public function simpan()
    {
        $ids = $this->request->getPost('id') ?? [];
        $tgl_mulai = $this->request->getPost('tgl_mulai') ?? [];
        $tgl_akhir = $this->request->getPost('tgl_akhir') ?? [];
        $aktif = $this->request->getPost('aktif') ?? [];

        foreach ($ids as $id) {
            $this->jadwalModel->update($id, [
                'tgl_mulai' => $tgl_mulai[$id] ?? null,
                'tgl_akhir' => $tgl_akhir[$id] ?? null,
                'aktif'     => in_array($id, $aktif) ? 1 : 0
            ]);
        }

        return redirect()->to('/ppdb/jadwal')->with('success', 'Jadwal pendaftaran berhasil diperbarui.');
    }
}