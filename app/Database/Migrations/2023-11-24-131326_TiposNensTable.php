<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TiposNensTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'descricao' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tipos_nens', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tipos_nens');
    }
}
