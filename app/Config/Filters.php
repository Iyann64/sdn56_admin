<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;

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
    ];

    /**
     * Filter globals
     */
    public array $globals = [
    'before' => [
        'csrf' => ['except' => ['login/proses']],  // ← tambahkan ini
    ],
    'after' => [
        'toolbar',
    ],
];

    public array $methods = [];

    /**
     * Filter auth berlaku di semua route KECUALI /login dan /login/proses
     */
    public array $filters = [
        'auth' => ['except' => ['login', 'login/proses']],
    ];
}