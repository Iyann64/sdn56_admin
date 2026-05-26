<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Data User (Agar Anda bisa login di device baru)
        $users = [
            [
                'nama'     => 'Super Admin',
                'email'    => 'admin@gmail.com',
                'role'     => 'Super Admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'avatar'   => 'A',
            ],
            [
                'nama'     => 'Kepala Sekolah',
                'email'    => 'kepala@gmail.com',
                'role'     => 'Kepala Sekolah',
                'password' => password_hash('sdn56pbm', PASSWORD_DEFAULT),
                'avatar'   => 'K',
            ],
            [
                'nama'     => 'Operator',
                'email'    => 'operator@gmail.com',
                'role'     => 'Operator',
                'password' => password_hash('operator56', PASSWORD_DEFAULT),
                'avatar'   => 'O',
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. Data Guru (Sesuai struktur UpdateGuruPrimaryKey)
        $guru = [
            [
                'nip'     => '198501012010011001',
                'nama'    => 'Budi Santoso, S.Pd',
                'id_guru' => 1
            ],
            [
                'nip'     => '199005122015032005',
                'nama'    => 'Siti Aminah, M.Pd',
                'id_guru' => 2
            ],
        ];
        $this->db->table('guru')->insertBatch($guru);

        // 3. Data PPDB (Contoh Pendaftar awal)
        $ppdb = [
            [
                'nama'              => 'Cahyani Putri',
                'nik_siswa'         => '1671012345670001',
                'nisn'              => '0123456789',
                'jenis_kelamin'     => 'Perempuan',
                'tempat_lahir'      => 'Prabumulih',
                'tgl_lahir'         => '2019-05-15',
                'agama'             => 'Islam',
                'usia'              => 6,
                'nama_ortu'         => 'Slamet',
                'nik_ortu'          => '1671012345679999',
                'telepon'           => '081234567890',
                'email'             => 'cahyani@gmail.com',
                'alamat'            => 'Jl. Sudirman No. 56',
                'asal'              => 'TK Pertiwi',
                'jalur_pendaftaran' => 'Domisili',
                'status'            => 'Menunggu',
                'tgl_daftar'        => date('Y-m-d'),
                'catatan'           => 'Pendaftar contoh',
            ]
        ];
        $this->db->table('ppdb')->insertBatch($ppdb);
    }
}