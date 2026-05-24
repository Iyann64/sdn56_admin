<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * RoleFilter — sdn56_admin
 * Kontrol akses berdasarkan role user
 *
 * Gunakan dalam route:
 *   $routes->get('/admin', 'Admin::index', ['filter' => 'role:Super Admin']);
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($arguments === null) {
            return; // Tidak ada restriction
        }

        // CodeIgniter passes filter arguments as ["Super Admin", "Operator"].
        // Keep support for legacy ["role:Super Admin,Operator"] format too.
        $allowedRoles = [];
        foreach ($arguments as $arg) {
            if (strpos($arg, 'role:') === 0) {
                $roles = explode(',', substr($arg, 5));
                $allowedRoles = array_merge($allowedRoles, array_map('trim', $roles));
                continue;
            }

            $allowedRoles[] = trim($arg);
        }

        $allowedRoles = array_filter(array_unique($allowedRoles));

        if (empty($allowedRoles)) {
            return; // Tidak ada role restriction
        }

        $userRole = session()->get('admin_user')['role'] ?? null;

        if (! in_array($userRole, $allowedRoles)) {
            return redirect()->to('/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
