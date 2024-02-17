<?php

namespace App\Validation;

class TipoHunterValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }
    public array $tipo_hunter_store = [
        'descricao' => 'required|max_length[50]',
    ];

    public array $tipo_hunter_update = [
        'descricao' => 'required|max_length[50]s',
    ];
}
