<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RecompensadosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'recompensa_id' => ['type' => 'INT'],
            'hunter_id' => ['type' => 'INT'],
            'concluida' => ['type' => 'BOOLEAN'],
            'created_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('recompensados', TRUE);
        $this->forge->addForeignKey('recompensa_id', 'recompensas', 'id');
        $this->forge->addForeignKey('hunter_id', 'hunters', 'id');
    }

    public function down()
    {
        $this->forge->dropTable('recompensados');
    }
}
