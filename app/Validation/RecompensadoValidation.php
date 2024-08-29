<?php

namespace App\Validation;

class RecompensadoValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public array $recompensado_store = [
        'recompensa_id' => 'required|integer|exists[recompensas,id]',
        'hunter_id' => 'required|integer|exists[hunters,id]',
        'concluida' => 'required',
    ];

    public array $recompensado_update = [
        'recompensa_id' => 'required|integer|exists[recompensas,id]',
        'hunter_id' => 'required|integer|exists[hunters,id]',
        'concluida' => 'required',
    ];
}
