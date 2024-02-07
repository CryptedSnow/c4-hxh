<?php

namespace App\Validation;

class RecompensadoValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public array $recompensado_store = [
        'recompensa_id' => 'required|integer',
        'hunter_id' => 'required|integer',
        'concluida' => 'required',
    ];

    public array $recompensado_update = [
        'recompensa_id' => 'required|integer',
        'hunter_id' => 'required|integer',
        'concluida' => 'required',
    ];
}
