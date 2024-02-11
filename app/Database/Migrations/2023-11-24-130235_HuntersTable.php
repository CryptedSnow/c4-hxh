<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HuntersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nome_hunter' => ['type' => 'VARCHAR', 'constraint' => 255],
            'idade_hunter' => ['type' => 'INT'],
            'altura_hunter' => ['type' => 'DOUBLE PRECISION'],
            'peso_hunter' => ['type' => 'DOUBLE PRECISION'],
            'tipo_hunter_id' => ['type' => 'INT'],
            'tipo_nen_id' => ['type' => 'INT'],
            'tipo_sangue_id' => ['type' => 'INT'],
            'inicio' => ['type' => 'DATE'],
            'termino' => ['type' => 'DATE'],
            'created_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
            'deleted_at' => ['type' => 'TIMESTAMP', 'NULL' => true],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('hunters', TRUE);
        $this->forge->addForeignKey('tipo_hunter_id', 'tipos_hunters', 'id');
        $this->forge->addForeignKey('tipo_nen_id', 'tipos_nens', 'id');
        $this->forge->addForeignKey('tipo_sangue_id', 'tipos_sanguineos', 'id');
    }

    public function down()
    {
        $this->forge->dropTable('hunters');
    }
}
