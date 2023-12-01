<?php

namespace App\Validation;

class RecompensadoValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public array $recompensado_store = [
        'recompensa_id' => 'required|exists:recompensas,_id',
        'hunter_id' => 'required|exists:hunters,_id',
        'concluida' => 'required|in:true',
    ];

    public array $recompensado_update = [
        'recompensa_id' => 'required|exists:recompensas,_id',
        'hunter_id' => 'required|exists:hunters,_id',
        'concluida' => 'required|boolean',
    ];
}
