<?php

namespace App\Validation;

class HunterValidation
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }

    public array $hunter_store = [
        'nome_hunter' => 'required|max_length[50]',
        'idade_hunter' => 'required|integer|greater_than_equal_to[13]',
        'altura_hunter' => 'required|decimal|greater_than_equal_to[1.50]|less_than_equal_to[2.50]',
        'peso_hunter' => 'required|numeric|greater_than_equal_to[50.00]|less_than_equal_to[150.00]',
        'tipo_hunter_id' => 'required',
        'tipo_nen_id' => 'required',
        'tipo_sangue_id' => 'required',
        'inicio' => 'required|valid_date',
        'termino' => 'required|valid_date',
    ];

    public array $hunter_update = [
        'nome_hunter' => 'required|max_length[50]',
        'idade_hunter' => 'required|integer|greater_than_equal_to[13]',
        'altura_hunter' => 'required|decimal|greater_than_equal_to[1.50]|less_than_equal_to[2.50]',
        'peso_hunter' => 'required|numeric|greater_than_equal_to[50.00]|less_than_equal_to[150.00]',
        'tipo_hunter_id' => 'required',
        'tipo_nen_id' => 'required',
        'tipo_sangue_id' => 'required',
        'inicio' => 'required|valid_date',
        'termino' => 'required|valid_date',
    ];

}