<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoHunterSeeder extends Seeder
{
    public function run()
    {
        $tipos_hunters = [
            ['descricao' => 'Hunter Gourmet'],
            ['descricao' => 'Hunter Arqueólogo'],
            ['descricao' => 'Hunter Cientista ou Hunter Técnico'],
            ['descricao' => 'Hunter Selvagem ou Hunter Ambientalista'],
            ['descricao' => 'Hunter Musical'],
            ['descricao' => 'Hunter Treasure'],
            ['descricao' => 'Hunter Lista Negra'],
            ['descricao' => 'Hunter Mercenário'],
            ['descricao' => 'Hunter Medicinal'],
            ['descricao' => 'Hunter Hacker'],
            ['descricao' => 'Hunter Cabeça'],
            ['descricao' => 'Hunter de Informação'],
            ['descricao' => 'Hunter Jackspot'],
            ['descricao' => 'Hunter Vírus'],
            ['descricao' => 'Hunter da Juventudade e Beleza'],
            ['descricao' => 'Hunter Terrorista'],
            ['descricao' => 'Hunter de Venenos'],
            ['descricao' => 'Hunter Caçador'],
            ['descricao' => 'Hunter Paleógrafo'],
            ['descricao' => 'Hunter Perdido'],
            ['descricao' => 'Hunter Provisório'],
            ['descricao' => 'Hunter Temporário'],
        ];

        $this->db->table('tipos_hunters')->insertBatch($tipos_hunters);
    }
}
