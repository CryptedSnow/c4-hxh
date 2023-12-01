<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TipoHunterModel;

class TipoHunterController extends ResourceController
{
    public function index()
    {
        $tipo_hunter = new TipoHunterModel();
        $dados = $tipo_hunter->findAll();
        $this->response->setContentType('application/json');
        return $this->response->setJSON($dados);
    }

    public function create()
    {
        $tipo_hunter = new TipoHunterModel();
        $validacao = $tipo_hunter->getRuleGroup('hunter_store');
        $this->response->setContentType('application/json');
        return $this->response->setStatusCode(200)->setJSON(['message' => 'Inserção bem-sucedia']);
    }

    public function show($id = null)
    {
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$tipo_hunter) {
            return $this->response->setStatusCode(404)->setJSON(['message' => "Registro $id não encontrado"]);
        }
        $this->response->setContentType('application/json');
        return $this->response->setJSON($registro);
    }

    public function update($id = null)
    {
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$registro) {
            return $this->response->setStatusCode(404)->setJSON(['message' => "Registro $id não encontrado"]);
        }
        $validacao = $registro->getRuleGroup('hunter_update');
        $this->response->setContentType('application/json');
        return $this->response->setJSON($registro);
    }

    public function delete($id = null)
    {
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$registro) {
            return $this->response->setStatusCode(404)->setJSON(['message' => "Registro $id não encontrado"]);
        }
        $registro->delete($id);
        $this->response->setContentType('application/json');
        return $this->response->setStatusCode(200)->setJSON(['message' => 'Exclusão bem-sucedida']);
    }
}
