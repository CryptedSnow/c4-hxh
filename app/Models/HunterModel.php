<?php

namespace App\Models;

use CodeIgniter\Model;

class HunterModel extends Model
{
    protected $table            = 'hunters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome_hunter','idade_hunter','altura_hunter','peso_hunter',
    'tipo_hunter_id','tipo_nen_id','tipo_sangue_id','inicio','termino'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function recompensado()
    {
        return $this->hasMany(RecompensadoModel::class, 'hunter_id');
    }

    public function getHunter($id)
    {
        return $this->find($id);
    }
}
