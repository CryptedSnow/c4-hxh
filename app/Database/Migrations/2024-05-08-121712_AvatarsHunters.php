<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AvatarsHunters extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'hunter_id' => ['type' => 'INT'],
            'imagem' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deleted_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('avatars_hunters', TRUE);
        $this->forge->addForeignKey('hunter_id', 'hunters', 'id');
    }

    public function down()
    {
        $this->forge->dropTable('avatars_hunters');
    }
}
