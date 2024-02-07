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
        'valor_recompensa' => 'required|decimal|greater_than_equal_to[0.00]|less_than_equal_to[1000000.00]d',
    ];

    public array $recompensa_update = [
        'descricao_recompensa' => 'required',
        'valor_recompensa' => 'required|decimal|greater_than_equal_to[0.00]|less_than_equal_to[1000000.00]',
    ];
}
