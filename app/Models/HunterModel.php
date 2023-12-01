<?php

namespace App\Models;

use CodeIgniter\Model;

class HunterModel extends Model
{
    protected $table            = 'hunters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nome_hunter','idade_hunter','altura_hunter','peso_hunter',
    'tipo_hunter_id','tipo_nen_id','tipo_sangue_id','inicio','termino'];

    public function recompensado()
    {
        return $this->hasMany(RecompensadoModel::class, 'hunter_id');
    }

    public function th()
    {
        return $this->belongsTo(TipoHunterModel::class, 'tipo_hunter_id');
    }

    public function tn()
    {
        return $this->belongsTo(TipoNenModel::class, 'tipo_nen_id');
    }

    public function ts()
    {
        return $this->belongsTo(TipoSanguineoModel::class, 'tipo_sangue_id');
    }

    public function getHunter($id)
    {
        return $this->find($id);
    }
}
