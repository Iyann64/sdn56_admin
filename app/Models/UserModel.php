<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel — sdn56_admin
 * Tabel: users (akun administrator)
 */
class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama', 'username', 'password',
        'email', 'telepon', 'role', 'avatar',
        'reset_token', 'token_expire',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /** Cari user berdasarkan username, lalu verifikasi password */
    public function cekLogin(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)->first();

        if (! $user) {
            return null;
        }

        if (! password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }

    /** Update password dengan hash baru */
    public function gantiPassword(int $id, string $passwordBaru): bool
    {
        return $this->update($id, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
        ]);
    }
}
