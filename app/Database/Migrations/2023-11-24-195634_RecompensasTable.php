<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RecompensasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'descricao_recompensa' => ['type' => 'VARCHAR', 'constraint' => 255],
            'valor_recompensa' => ['type' => 'DOUBLE PRECISION'],
            'created_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('recompensas', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('recompensas');
    }
}
