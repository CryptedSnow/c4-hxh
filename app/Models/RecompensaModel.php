<?php

namespace App\Models;

use CodeIgniter\Model;

class RecompensaModel extends Model
{
    protected $table            = 'recompensas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['descricao_recompensa', 'valor_recompensa'];

    public function recompensados()
    {
        return $this->hasMany(RecompensadoModel::class, 'recompensa_id');
    }
}