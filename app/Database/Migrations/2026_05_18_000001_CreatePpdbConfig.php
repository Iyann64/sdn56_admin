<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePpdbConfig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ppdb_config' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kunci'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'nilai'          => ['type' => 'TEXT', 'null' => true],
            'tipe'           => ['type' => 'ENUM', 'constraint' => ['string', 'integer', 'date', 'boolean'], 'default' => 'string'],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id_ppdb_config');
        $this->forge->addUniqueKey('kunci');
        $this->forge->createTable('ppdb_config', true);

        // Hanya isi data jika tabel kosong untuk menghindari error Duplicate Entry
        if ($this->db->table('ppdb_config')->countAllResults() === 0) {
            $this->db->table('ppdb_config')->insertBatch([
                ['kunci' => 'tgl_buka', 'nilai' => '1 April 2026', 'tipe' => 'string', 'deskripsi' => 'Tanggal pembukaan pendaftaran PPDB'],
                ['kunci' => 'tgl_tutup', 'nilai' => '31 Mei 2026', 'tipe' => 'string', 'deskripsi' => 'Tanggal penutupan pendaftaran PPDB'],
                ['kunci' => 'kuota', 'nilai' => '4 Rombongan Belajar', 'tipe' => 'string', 'deskripsi' => 'Kuota penerimaan siswa baru'],
                ['kunci' => 'usia_min', 'nilai' => '6', 'tipe' => 'integer', 'deskripsi' => 'Usia minimum siswa (tahun)'],
                ['kunci' => 'usia_max', 'nilai' => '7', 'tipe' => 'integer', 'deskripsi' => 'Usia maksimum siswa (tahun)'],
                ['kunci' => 'usia_text', 'nilai' => '6 - 7 Tahun', 'tipe' => 'string', 'deskripsi' => 'Teks tampilan usia'],
                ['kunci' => 'status', 'nilai' => 'Sedang Berlangsung', 'tipe' => 'string', 'deskripsi' => 'Status PPDB'],
                ['kunci' => 'peringatan_daftar_ulang', 'nilai' => 'Jika calon siswa yang sudah dinyatakan diterima tidak melakukan daftar ulang sesuai jadwal, maka dianggap mengundurkan diri.', 'tipe' => 'string', 'deskripsi' => 'Peringatan untuk daftar ulang'],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('ppdb_config');
    }
}
