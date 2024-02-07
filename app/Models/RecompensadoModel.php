<?php

namespace App\Models;

use CodeIgniter\Model;

class RecompensadoModel extends Model
{
    protected $table            = 'recompensados';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['recompensa_id', 'hunter_id', 'concluida'];

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


    public function hunter()
    {
        return $this->belongsTo(HunterModel::class, 'hunter_id');
    }

    public function recompensa()
    {
        return $this->belongsTo(RecompensaModel::class, 'recompensa_id');
    }

    public function getRecompensado($id)
    {
        return $this->find($id);
    }
}