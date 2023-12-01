<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoNenSeeder extends Seeder
{
    public function run()
    {
        $tipos_nens = [
            ['descricao' => 'Reforço'],
            ['descricao' => 'Emissão'],
            ['descricao' => 'Transformação'],
            ['descricao' => 'Manipulação'],
            ['descricao' => 'Materialização'],
            ['descricao' => 'Especialização'],
        ];

        $this->db->table('tipos_nens')->insertBatch($tipos_nens);
    }
}
