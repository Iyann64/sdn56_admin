<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PpdbConfigModel;

/**
 * Settings Controller — sdn56_admin
 */
class Settings extends BaseController
{
    private PpdbConfigModel $configModel;

    public function __construct()
    {
        $this->configModel = new PpdbConfigModel();
    }

    public function index(): string
    {
        $config = $this->configModel->getConfig();

        return $this->render('pages/settings/index', [
            'title'     => 'Pengaturan',
            'page_icon' => '⚙️',
            'user'      => session()->get('admin_user'),
            'sekolah'   => [
                'nama'       => 'SD Negeri 56 Prabumulih',
                'npsn'       => '10606345',
                'kepala'     => 'Dra. Hj. Siti Rahayu',
                'akreditasi' => 'A (Unggul)',
                'telepon'    => '(0713) 123-4567',
                'email'      => 'sdnegeri56pbm@gmail.com',
                'alamat'     => 'Jl. Pendidikan No. 56, Prabumulih, Sumatera Selatan 31124',
            ],
            'ppdb_config' => $config,
        ]);
    }

    public function simpanProfil()
    {
        $adminUser         = session()->get('admin_user');
        $adminUser['nama'] = $this->request->getPost('nama');
        session()->set('admin_user', $adminUser);

        if (isset($adminUser['id'])) {
            (new UserModel())->update($adminUser['id'], [
                'nama'  => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
            ]);
        }

        return redirect()->to('/settings')->with('success', 'Profil berhasil disimpan!');
    }

    public function ubahPassword()
    {
        $current = $this->request->getPost('pw_current');
        $new     = $this->request->getPost('pw_new');
        $confirm = $this->request->getPost('pw_confirm');

        if (empty($current) || empty($new))
            return redirect()->to('/settings')->with('error', 'Semua field wajib diisi!');
        if (strlen($new) < 6)
            return redirect()->to('/settings')->with('error', 'Password minimal 6 karakter!');
        if ($new !== $confirm)
            return redirect()->to('/settings')->with('error', 'Konfirmasi password tidak cocok!');

        $adminUser = session()->get('admin_user');
        $userModel = new UserModel();
        $user      = $userModel->find($adminUser['id'] ?? 0);

        if (! $user || ! password_verify($current, $user['password']))
            return redirect()->to('/settings')->with('error', 'Password lama tidak sesuai!');

        $userModel->gantiPassword($user['id'], $new);
        return redirect()->to('/settings')->with('success', 'Password berhasil diubah!');
    }

    public function simpanSekolah()
    {
        return redirect()->to('/settings')->with('success', 'Info sekolah berhasil disimpan!');
    }

    public function simpanPpdbConfig()
    {
        $data = [
            'status'   => $this->request->getPost('status'),
            'tgl_buka' => $this->request->getPost('tgl_buka'),
            'tgl_tutup'=> $this->request->getPost('tgl_tutup'),
            'kuota'    => $this->request->getPost('kuota'),
            'kuota_afirmasi' => $this->request->getPost('kuota_afirmasi'),
            'kuota_mutasi'   => $this->request->getPost('kuota_mutasi'),
            'kuota_domisili' => $this->request->getPost('kuota_domisili'),
            'jalur_pendaftaran' => $this->request->getPost('jalur_pendaftaran'),
            'usia_min' => $this->request->getPost('usia_min'),
            'usia_max' => $this->request->getPost('usia_max'),
        ];

        $this->configModel->update(1, $data);

        return redirect()->to('/settings')->with('success', 'Konfigurasi PPDB berhasil diperbarui!');
    }
}