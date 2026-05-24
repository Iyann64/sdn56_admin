<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateGuruPrimaryKey extends Migration
{
    public function up()
    {
        // 1. Matikan Auto Increment pada id_guru jika kolomnya ada agar PK bisa dilepas
        if ($this->db->fieldExists('id_guru', 'guru')) {
            $this->db->query("ALTER TABLE guru MODIFY COLUMN id_guru INT UNSIGNED NOT NULL");
        }

        // 2. Hapus Primary Key yang saat ini aktif
        try {
            $this->db->query("ALTER TABLE guru DROP PRIMARY KEY");
        } catch (\Exception $e) {}

        // 3. Pastikan kolom id_guru ada (buat jika hilang) dan jadikan UNIQUE
        if (!$this->db->fieldExists('id_guru', 'guru')) {
            $this->forge->addColumn('guru', [
                'id_guru' => [
                    'type'       => 'INT',
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'nama' 
                ]
            ]);
        }

        // Tambahkan index UNIQUE ke id_guru
        try {
            $this->db->query("ALTER TABLE guru ADD UNIQUE (id_guru)");
        } catch (\Exception $e) {}

        // 4. Jadikan NIP sebagai PRIMARY KEY + AUTO_INCREMENT
        // Kita ubah ke BIGINT karena NIP 18 digit terlalu besar untuk INT biasa
        $this->db->query("ALTER TABLE guru MODIFY nip BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE guru MODIFY nip BIGINT UNSIGNED NOT NULL");
        $this->db->query("ALTER TABLE guru DROP PRIMARY KEY");
        if ($this->db->fieldExists('id_guru', 'guru')) {
            $this->db->query("ALTER TABLE guru DROP INDEX id_guru");
            $this->db->query("ALTER TABLE guru ADD PRIMARY KEY (id_guru)");
            $this->db->query("ALTER TABLE guru MODIFY id_guru INT UNSIGNED NOT NULL AUTO_INCREMENT");
        }
    }
}