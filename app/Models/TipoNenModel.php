<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoNenModel extends Model
{
    protected $table            = 'tipos_nens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['descricao'];

    public function tipo_nen()
    {
        return $this->hasMany(HunterModel::class, 'tipo_nen_id');
    }
}