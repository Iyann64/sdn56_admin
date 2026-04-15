<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * AuthFilter — sdn56_admin
 * Proteksi semua route agar hanya bisa diakses setelah login.
 *
 * Daftarkan di app/Config/Filters.php:
 *   $aliases = ['auth' => \App\Filters\AuthFilter::class];
 *   $filters = ['auth' => ['before' => ['*', 'except' => ['login', 'login/proses']]]];
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}