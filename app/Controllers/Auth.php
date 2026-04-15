<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ─── GET /login ───────────────────────────────────────────────
    public function login(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', array_merge($this->data, [
            'title'   => 'Login Admin',
            'error'   => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
        ]));
    }

    // ─── POST /login/proses ───────────────────────────────────────
    public function proses()
{
    $username = trim($this->request->getPost('username'));
    $password = $this->request->getPost('password');

    if (empty($username) || empty($password)) {
        return redirect()->to('/login')
            ->with('error', 'Username dan password wajib diisi.');
    }

    $userModel = new UserModel();
    $user      = $userModel->cekLogin($username, $password);

    if (! $user) {
        sleep(1);
        return redirect()->to('/login')
            ->with('error', 'Username atau password salah.')
            ->withInput();
    }

    session()->set([
        'logged_in'  => true,
        'user_id'    => $user['id'],
        'admin_user' => [
            'id'     => $user['id'],
            'nama'   => $user['nama'],
            'role'   => $user['role'],
            'email'  => $user['email'] ?? '',
            'avatar' => $user['avatar'] ?? strtoupper(substr($user['nama'], 0, 1)),
        ],
    ]);

    return redirect()->to('/dashboard');
}

    // ─── GET /logout ──────────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')
            ->with('success', 'Anda berhasil keluar. Sampai jumpa!');
    }
}