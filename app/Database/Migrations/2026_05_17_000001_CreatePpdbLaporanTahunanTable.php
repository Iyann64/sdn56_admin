<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbLaporanTahunanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun_ajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'comment'    => 'Format: 2025/2026',
            ],
            'tahun' => [
                'type'       => 'YEAR',
                'comment'    => 'Tahun laporan (2025 atau 2026)',
            ],
            'total_pendaftar' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'total_diterima' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'total_menunggu' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'total_ditolak' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'total_laki_laki' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'total_perempuan' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'rata_rata_usia' => [
                'type'  => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_laporan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'comment'    => 'Path file laporan PDF/Excel jika ada',
            ],
            'dibuat_oleh' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'comment'    => 'User ID yang membuat laporan',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Draft', 'Final', 'Arsip'],
                'default'    => 'Draft',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('tahun_ajaran');
        $this->forge->addKey('tahun');
        $this->forge->addKey('status');
        $this->forge->addKey('dibuat_oleh');
        $this->forge->createTable('ppdb_laporan_tahunan', true);
    }

    public function down()
    {
        $this->forge->dropTable('ppdb_laporan_tahunan', true);
    }
}
