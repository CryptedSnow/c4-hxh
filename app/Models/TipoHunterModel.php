<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoHunterModel extends Model
{
    protected $table            = 'tipos_hunters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['descricao'];

    public function tipo_hunter()
    {
        return $this->hasMany(HunterModel::class, 'tipo_hunter_id');
    }
}
