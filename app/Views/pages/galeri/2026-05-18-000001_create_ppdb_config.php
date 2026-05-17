<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbConfig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 1, 'unsigned' => true, 'auto_increment' => true],
            'status'           => ['type' => 'ENUM', 'constraint' => ['Belum Dibuka', 'Sedang Berlangsung', 'Ditutup'], 'default' => 'Belum Dibuka'],
            'tgl_buka'         => ['type' => 'DATE', 'null' => true],
            'tgl_tutup'        => ['type' => 'DATE', 'null' => true],
            'kuota'            => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'usia_min'         => ['type' => 'INT', 'constraint' => 2, 'default' => 6],
            'usia_max'         => ['type' => 'INT', 'constraint' => 2, 'default' => 7],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('ppdb_config');

        // Insert data awal
        $this->db->table('ppdb_config')->insert([
            'status' => 'Belum Dibuka',
            'usia_min' => 6,
            'usia_max' => 7
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('ppdb_config');
    }
}