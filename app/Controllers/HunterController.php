<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HunterModel;
use App\Models\TipoHunterModel;
use App\Models\TipoSanguineoModel;
use App\Models\TipoNenModel;
use App\Validation\HunterValidation;

class HunterController extends BaseController
{
    public function index()
    {
        $model = new HunterModel();
        $hunter = new TipoHunterModel();
        $nen = new TipoNenModel();
        $sanguineo = new TipoSanguineoModel();

        // Obtém os resultados dos modelos
        $tipos_hunters = $hunter->findAll();
        $tipos_nens = $nen->findAll();
        $tipos_sanguineos = $sanguineo->findAll();

        // Reindexa os arrays começando de 1 ao invés de 0
        $tipos_hunters = array_column($tipos_hunters, null, 'id');
        $tipos_nens = array_column($tipos_nens, null, 'id');
        $tipos_sanguineos = array_column($tipos_sanguineos, null, 'id');

        $hunters = [
            'hunters' => $model->paginate(10),
            'pager' => $model->pager,
            'tipos_hunters' => $tipos_hunters, 
            'tipos_nens' => $tipos_nens, 
            'tipos_sanguineos' => $tipos_sanguineos, 
        ];
        return view('hunter/index', $hunters);
    }

    public function create()
    {
        $hunter = new TipoHunterModel();
        $nen = new TipoNenModel();
        $sanguineo = new TipoSanguineoModel();

        $tipos_hunters = $hunter->findAll();
        $tipos_nens = $nen->findAll();
        $tipos_sanguineos = $sanguineo->findAll();

        $tipos_hunters = array_column($tipos_hunters, null, 'id');
        $tipos_nens = array_column($tipos_nens, null, 'id');
        $tipos_sanguineos = array_column($tipos_sanguineos, null, 'id');
        
        $dados = [
            'tipos_hunters' => $tipos_hunters, 
            'tipos_nens' => $tipos_nens, 
            'tipos_sanguineos' => $tipos_sanguineos, 
        ];
        return view('hunter/create', $dados);
    }

    public function store()
    {
        $model = new HunterModel();
        $validacoes = new HunterValidation();
        if (!$this->validate($validacoes->hunter_store)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados = [
            'nome_hunter' => trim($this->request->getVar('nome_hunter')),
            'idade_hunter' => (int) $this->request->getVar('idade_hunter'),
            'altura_hunter' => (double) $this->request->getVar('altura_hunter'),
            'peso_hunter' => (double) $this->request->getVar('peso_hunter'),
            'tipo_hunter_id' => (int) $this->request->getVar('tipo_hunter_id'),
            'tipo_nen_id' => (int) $this->request->getVar('tipo_nen_id'),
            'tipo_sangue_id' => (int) $this->request->getVar('tipo_sangue_id'),
            'inicio' => $this->request->getVar('inicio'),
            'termino' => $this->request->getVar('termino'),
        ];
        $model->insert($dados);
        $primeiro_nome = explode(' ', $dados['nome_hunter'])[0];
        session()->setFlashdata('success', "Hunter $primeiro_nome foi inserido com sucesso.");
        return redirect()->to(base_url('hunter/index'));
    }

    public function view($id)
    {
        $model = new HunterModel();
        $hunter = new TipoHunterModel();
        $nen = new TipoNenModel();
        $sanguineo = new TipoSanguineoModel();

        $tipos_hunters = $hunter->findAll();
        $tipos_nens = $nen->findAll();
        $tipos_sanguineos = $sanguineo->findAll();

        $tipos_hunters = array_column($tipos_hunters, null, 'id');
        $tipos_nens = array_column($tipos_nens, null, 'id');
        $tipos_sanguineos = array_column($tipos_sanguineos, null, 'id');

        $dados = [
            'hunters' => $model->getHunter($id),
            'tipos_hunters' => $tipos_hunters, 
            'tipos_nens' => $tipos_nens, 
            'tipos_sanguineos' => $tipos_sanguineos, 
        ];
        return view('hunter/view', $dados);
    }

    public function edit($id)
    {
        $model = new HunterModel();
        $hunter = new TipoHunterModel();
        $nen = new TipoNenModel();
        $sanguineo = new TipoSanguineoModel();

        $tipos_hunters = $hunter->findAll();
        $tipos_nens = $nen->findAll();
        $tipos_sanguineos = $sanguineo->findAll();

        $tipos_hunters = array_column($tipos_hunters, null, 'id');
        $tipos_nens = array_column($tipos_nens, null, 'id');
        $tipos_sanguineos = array_column($tipos_sanguineos, null, 'id');

        $dados = [
            'hunters' => $model->getHunter($id),
            'tipos_hunters' => $tipos_hunters, 
            'tipos_nens' => $tipos_nens, 
            'tipos_sanguineos' => $tipos_sanguineos,  
        ];
        return view('hunter/edit', $dados);
    }

    public function update($id)
    {
        $model = new HunterModel();
        $validacoes = new HunterValidation();
        if (!$this->validate($validacoes->hunter_update)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados = [
            'nome_hunter' => trim($this->request->getVar('nome_hunter')),
            'idade_hunter' => (int) $this->request->getVar('idade_hunter'),
            'altura_hunter' => (double) $this->request->getVar('altura_hunter'),
            'peso_hunter' => (double) $this->request->getVar('peso_hunter'),
            'tipo_hunter_id' => (int) $this->request->getVar('tipo_hunter_id'),
            'tipo_nen_id' => (int) $this->request->getVar('tipo_nen_id'),
            'tipo_sangue_id' => (int) $this->request->getVar('tipo_sangue_id'),
            'inicio' => $this->request->getVar('inicio'),
            'termino' => $this->request->getVar('termino'),
        ];
        $model->update($id, $dados);
        $primeiro_nome = explode(' ', $dados['nome_hunter'])[0];
        session()->setFlashdata('info', "Hunter $primeiro_nome foi atualizado com sucesso.");
        return redirect()->to(base_url('hunter/index'));
    }

    public function delete($id)
    {
        $model = new HunterModel();
        $registro = $model->find($id);
        $primeiro_nome = explode(' ', $registro['nome_hunter'])[0];
        $model->delete($id);
        session()->setFlashdata('danger', "Hunter $primeiro_nome foi excluído com sucesso.");
        return redirect()->to(base_url('hunter/index'));
    }

}