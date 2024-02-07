<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\{RecompensaModel,RecompensadoModel};
use App\Validation\RecompensaValidation;

class RecompensaController extends BaseController
{
    public function index()
    {
        $model = new RecompensaModel();
        $recompensas = [
            'recompensas' => $model->paginate(5),
            'pager' => $model->pager,
        ];
        return view('recompensa/index', $recompensas);
    }

    public function search()
    {
        $model = new RecompensaModel();
        $pesquisa = $this->request->getGet('search');
        $recompensas = [
            'recompensas' => $model->like('descricao_recompensa', $pesquisa, 'both')->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
        ];
        return view('recompensa/index', $recompensas);
    }

    public function create()
    {
        return view('recompensa/create');
    }

    public function store()
    {
        $model = new RecompensaModel();
        $validacoes = new RecompensaValidation();
        if (!$this->validate($validacoes->recompensa_store)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados_tratados = [
            'descricao_recompensa' => trim($this->request->getVar('descricao_recompensa')),
            'valor_recompensa' => (double) $this->request->getVar('valor_recompensa'),
        ];
        $model->insert($dados_tratados);
        $nome_recompensa = $dados_tratados['descricao_recompensa'];
        log_message('notice', "Recompensa $nome_recompensa foi adicionada.");
        return redirect()->to(route_to('indexRecompensa'))->with('success', "Recompensa $nome_recompensa foi inserida com sucesso.");
    }

    public function view($id)
    {
        $model = new RecompensaModel();
        $dados = [
            'recompensas' => $model->getRecompensa($id), 
        ];
        return view('recompensa/view', $dados);
    }

    public function edit($id)
    {
        $model = new RecompensaModel();
        $dados = [
            'recompensas' => $model->getRecompensa($id), 
        ];
        return view('recompensa/edit', $dados);
    }

    public function update($id)
    {
        $model = new RecompensaModel();
        $validacoes = new RecompensaValidation();
        if (!$this->validate($validacoes->recompensa_update)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados_tratados = [
            'descricao_recompensa' => trim($this->request->getVar('descricao_recompensa')),
            'valor_recompensa' => (double) $this->request->getVar('valor_recompensa'),
        ];
        $model->update($id, $dados_tratados);
        $nome_recompensa = $dados_tratados['descricao_recompensa'];
        log_message('info', "Recompensa $nome_recompensa obteve atualizações.");
        return redirect()->to(route_to('indexRecompensa'))->with('info', "Recompensa $nome_recompensa foi atualizada com sucesso.");
    }

    public function delete($id)
    {
        $model = new RecompensaModel();
        $registro = $model->find($id);
        $nome_recompensa = $registro['descricao_recompensa'];
        $model->delete($id);
        log_message('warning', "Recompensa $nome_recompensa foi adicionada à lixeira.");
        return redirect()->to(route_to('indexRecompensa'))->with('warning', "Recompensa $nome_recompensa foi enviada para a lixeira.");
    }

    public function onlyDeleted()
    {
        $model = new RecompensaModel();
        $recompensas = [
            'recompensas' => $model->onlyDeleted()->paginate(5),
            'pager' => $model->pager,
        ];
        return view('recompensa/trash', $recompensas);
    }

    public function searchTrash()
    {
        $model = new RecompensaModel();
        $pesquisa = $this->request->getGet('search');
        $recompensas = [
            'recompensas' => $model->onlyDeleted()->like('descricao_recompensa', $pesquisa, 'both')->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
        ];
        return view('recompensa/trash', $recompensas);
    }

    public function restoreDeleted($id)
    {
        $model = new RecompensaModel();
        $registro_deletado = $model->onlyDeleted()->find($id);
        $nome_recompensa = $registro_deletado['descricao_recompensa'];
        if ($registro_deletado) {
            $model->onlyDeleted()->builder()->update(['deleted_at' => null], ['id' => $id]);
            log_message('info', "Recompensa $nome_recompensa foi restaurada.");
            return redirect()->to(route_to('trashRecompensa'))->with('success', "Recompensa $nome_recompensa retornou para a listagem principal.");
        } else {
            return redirect()->to(route_to('trashRecompensa'))->with('warning', "Recompensa $nome_recompensa não encontrada ou já restaurada.");
        }
    }

    public function deletePermanently($id)
    {
        $model = new RecompensaModel();
        $recompensado = new RecompensadoModel();
        $registro_deletado = $model->onlyDeleted()->find($id);
        $nome_recompensa = $registro_deletado['descricao_recompensa'];
        $quantidade_recompensas = $recompensado->where('recompensa_id', $id)->countAllResults();
        if ($quantidade_recompensas > 0){
            return redirect()->to(route_to('trashRecompensa'))->with('warning', "Não é possível excluir $nome_recompensa permanentemente, pois está associado em $quantidade_recompensas registro(s) de recompensados.");
        }
        $model->onlyDeleted()->where('id', $id)->purgeDeleted();
        log_message('alert', "Recompensa $nome_recompensa foi excluída permanentemente.");
        return redirect()->to(route_to('trashRecompensa'))->with('danger', "Recompensa $nome_recompensa foi excluída permanentemente.");
    }
}