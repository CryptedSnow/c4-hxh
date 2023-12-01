<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoSanguineoSeeder extends Seeder
{
    public function run()
    {
        $tipos_sanguineos = [
            ['descricao' => 'A+'],
            ['descricao' => 'A-'],
            ['descricao' => 'B+'],
            ['descricao' => 'B-'],
            ['descricao' => 'AB+'],
            ['descricao' => 'AB-'],
            ['descricao' => 'O+'],
            ['descricao' => 'O-'],
        ];

        $this->db->table('tipos_sanguineos')->insertBatch($tipos_sanguineos);
    }
}
