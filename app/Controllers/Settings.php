<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Settings Controller — sdn56_admin
 */
class Settings extends BaseController
{
    public function index(): string
    {
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
            'ppdb_config' => [
                'tgl_buka'         => '2026-04-01',
                'tgl_tutup'        => '2026-05-31',
                'kuota_rombel'     => 4,
                'kuota_per_rombel' => 28,
                'usia_min'         => 6,
                'usia_max'         => 7,
                'status'           => 'Belum Dibuka',
            ],
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
        return redirect()->to('/settings')->with('success', 'Konfigurasi PPDB berhasil disimpan!');
    }
}