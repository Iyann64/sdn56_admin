<?php

/**
 * PermissionHelper — sdn56_admin
 * Helper untuk checking permission berdasarkan role
 */

/**
 * Cek apakah user role memiliki akses ke action tertentu
 * 
 * @param string $resource Nama resource (berita, ppdb, agenda, galeri, guru, settings)
 * @param string $action Nama action (view, create, edit, delete)
 * @return bool
 */
function hasPermission(string $resource, string $action = 'view'): bool
{
    $userRole = session()->get('admin_user')['role'] ?? null;
    
    if (!$userRole) {
        return false;
    }

    // Super Admin punya akses penuh
    if ($userRole === 'Super Admin') {
        return true;
    }

    // Define permission matrix
    $permissions = [
        // Kepala Sekolah
        'Kepala Sekolah' => [
            'berita' => ['view'],
            'agenda' => ['view'],
            'galeri' => ['view'],
            'ppdb' => ['view'], // Only view, no edit/delete
            'guru' => ['view'],
            'settings' => [], // No access
            'dashboard' => ['view'],
        ],
        // Operator
        'Operator' => [
            'berita' => ['view', 'create', 'edit', 'delete'],
            'ppdb' => ['view', 'create', 'edit', 'delete'],
            'agenda' => ['view', 'create', 'edit', 'delete'],
            'galeri' => ['view', 'create', 'edit', 'delete'],
            'guru' => ['view', 'create', 'edit', 'delete'],
            'settings' => [], // No access
            'dashboard' => ['view'],
        ],
    ];

    $userPermissions = $permissions[$userRole] ?? [];
    $resourcePermissions = $userPermissions[$resource] ?? [];

    return in_array($action, $resourcePermissions);
}

/**
 * Cek apakah user bisa akses resource tertentu
 * 
 * @param string $resource Nama resource
 * @return bool
 */
function canAccess(string $resource): bool
{
    return hasPermission($resource, 'view');
}

/**
 * Get user role dengan format yang bagus
 * 
 * @return string
 */
function getUserRole(): string
{
    return session()->get('admin_user')['role'] ?? 'Guest';
}

/**
 * Cek apakah user adalah Super Admin
 * 
 * @return bool
 */
function isSuperAdmin(): bool
{
    return getUserRole() === 'Super Admin';
}

/**
 * Cek apakah user adalah Kepala Sekolah
 * 
 * @return bool
 */
function isKepalaSekolah(): bool
{
    return getUserRole() === 'Kepala Sekolah';
}

/**
 * Cek apakah user adalah Operator
 * 
 * @return bool
 */
function isOperator(): bool
{
    return getUserRole() === 'Operator';
}
