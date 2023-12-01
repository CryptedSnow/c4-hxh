<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoSanguineoModel extends Model
{
    protected $table            = 'tipos_sanguineos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['descricao'];

    public function tipo_sanguineo()
    {
        return $this->hasMany(HunterModel::class, 'tipo_sanguineo_id');
    }
 
}