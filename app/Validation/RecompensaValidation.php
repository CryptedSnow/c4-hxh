<?php

namespace App\Validation;

class RecompensaValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }
    
    public array $recompensa_store = [
        'descricao_recompensa' => 'required',
        'valor_recompensa' => 'required|numeric|min:0.00|max:1000000.00',
    ];

    public array $recompensa_update = [
        'descricao_recompensa' => 'required',
        'valor_recompensa' => 'required|numeric|min:0.00|max:1000000.00',
    ];
}
