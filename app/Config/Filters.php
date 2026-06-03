<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;
use App\Filters\RoleFilter;

class Filters extends BaseConfig
{
    /**
     * Filter aliases
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => AuthFilter::class,   // ← autentikasi admin
        'role'          => RoleFilter::class,   // ← role-based access control
    ];

    /**
     * Filter globals
     */
    public array $globals = [
        'before' => [
            'csrf'  => ['except' => ['login/proses']],
            'auth'  => ['except' => [
                'login',
                'login/proses',
                'forgot-password',
                'forgot-password/kirim',
                'reset-password/*',
                'reset-password/simpan',
            ]],  // ← proteksi semua route, kecuali auth publik
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    /**
     * Filter auth berlaku di semua route KECUALI /login dan /login/proses
     */
    public array $filters = [];
}
