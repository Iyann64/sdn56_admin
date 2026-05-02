<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResetPasswordToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'comment'    => 'Token untuk reset password'
            ],
            'token_expire' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Waktu expired token reset password'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['reset_token', 'token_expire']);
    }
}
