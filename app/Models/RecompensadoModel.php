<?php

namespace App\Models;

use CodeIgniter\Model;

class RecompensadoModel extends Model
{
    protected $table            = 'recompensados';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['recompensa_id', 'hunter_id', 'concluida'];


    public function hunter()
    {
        return $this->belongsTo(HunterModel::class, 'hunter_id');
    }

    public function recompensa()
    {
        return $this->belongsTo(RecompensaModel::class, 'recompensa_id');
    }
}