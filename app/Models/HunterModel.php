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

    public function deleteDirectoryContents($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file)) { 
                $this->deleteDirectoryContents($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
    }

    public function moveDirectory($source, $destination) {
        if (!is_dir($source)) {
            return false;
        }
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }
        $directory = dir($source);
        while (false !== ($entry = $directory->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $sourcePath = $source . '/' . $entry;
            $destinationPath = $destination . '/' . $entry;
            if (is_dir($sourcePath)) {
                $this->moveDirectory($sourcePath, $destinationPath);
                rmdir($sourcePath);
            } else {
                rename($sourcePath, $destinationPath);
            }
        }
        $directory->close();
        return true;
    }

}