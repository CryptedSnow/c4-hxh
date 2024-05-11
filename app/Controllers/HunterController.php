<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\{AvatarHunterModel,HunterModel,RecompensadoModel,TipoHunterModel,TipoSanguineoModel,TipoNenModel};
use App\Validation\HunterValidation;
use CILogViewer\CILogViewer;

class HunterController extends BaseController
{
    
    public function index()
    {
        $model = new HunterModel();
        $hunters = [
            'hunters' => $model->select('hunters.id, hunters.nome_hunter, 
            hunters.altura_hunter, hunters.idade_hunter, hunters.peso_hunter,
            tipos_hunters.descricao AS descricao_tipo_hunter,
            tipos_nens.descricao AS descricao_tipo_nen,
            tipos_sanguineos.descricao AS descricao_tipo_sanguineo,
            hunters.inicio, hunters.termino')
            ->join('tipos_hunters', 'tipos_hunters.id = hunters.tipo_hunter_id')
            ->join('tipos_nens', 'tipos_nens.id = hunters.tipo_nen_id')
            ->join('tipos_sanguineos', 'tipos_sanguineos.id = hunters.tipo_sangue_id')
            ->paginate(5),
            'pager' => $model->pager,
        ];
        return view('hunter/index', $hunters);
    }

    public function search()
    {
        $model = new HunterModel();
        $pesquisa = $this->request->getGet('search');
        $hunters = [
            'hunters' => $model->select('hunters.id, hunters.nome_hunter, 
            hunters.altura_hunter, hunters.idade_hunter, hunters.peso_hunter,
            tipos_hunters.descricao AS descricao_tipo_hunter,
            tipos_nens.descricao AS descricao_tipo_nen,
            tipos_sanguineos.descricao AS descricao_tipo_sanguineo,
            hunters.inicio, hunters.termino')
            ->join('tipos_hunters', 'tipos_hunters.id = hunters.tipo_hunter_id')
            ->join('tipos_nens', 'tipos_nens.id = hunters.tipo_nen_id')
            ->join('tipos_sanguineos', 'tipos_sanguineos.id = hunters.tipo_sangue_id')
            ->like('hunters.nome_hunter', $pesquisa, 'both')->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
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
        $dados_tratados = [
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
        $hunter_id = $model->insert($dados_tratados);
        $nome_inteiro = $dados_tratados['nome_hunter'];
        $primeiro_nome = explode(' ', $dados_tratados['nome_hunter'])[0];
        log_message('notice', "Hunter $nome_inteiro foi adicionado.");
        if ($this->request->getFiles()) {
            $avatar_hunter_model = new AvatarHunterModel();
            foreach ($this->request->getFiles()['avatar'] as $avatar) {
                $nome_original = $avatar->getName();
                $caminho_imagem = 'uploads/avatars/' . $hunter_id . '/' . $nome_original;
                $avatar->move(WRITEPATH . 'uploads/avatars/' . $hunter_id, $nome_original);
                $avatar_hunter_model->insert([
                    'hunter_id' => $hunter_id,
                    'imagem' => $caminho_imagem
                ]);
            }
        }
        return redirect()->to(route_to('indexHunter'))->with('success', "Hunter $primeiro_nome foi inserido com sucesso.");
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
        $dados_tratados = [
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
        $model->update($id, $dados_tratados);
        if ($this->request->getFileMultiple('avatar')[0]->isValid()) {
            $avatar_hunter_model = new AvatarHunterModel();
            $avatar_hunter_model->where('hunter_id', $id)->delete();
            foreach ($this->request->getFileMultiple('avatar') as $avatar) {
                $nome_original = $avatar->getName();
                $caminho_imagem = 'uploads/avatars/' . $id . '/' . $nome_original;
                $avatar->move(WRITEPATH . 'uploads/avatars/' . $id, $nome_original);
                $avatar_hunter_model->insert([
                    'hunter_id' => $id,
                    'imagem' => $caminho_imagem,
                ]);
            }
        }
        $primeiro_nome = explode(' ', $dados_tratados['nome_hunter'])[0];
        $nome_inteiro = $dados_tratados['nome_hunter'];
        log_message('info', "Hunter $nome_inteiro obteve atualizações.");
        return redirect()->to(route_to('indexHunter'))->with('info', "Hunter $primeiro_nome foi atualizado com sucesso.");
    }

    public function delete($id)
    {
        $model = new HunterModel();
        $registro = $model->find($id);
        $primeiro_nome = explode(' ', $registro['nome_hunter'])[0];
        if ($registro) {
            $caminho_imagem = WRITEPATH . 'uploads/avatars/' . $id;
            $trash_avatars_caminho = WRITEPATH . 'uploads/trash/avatars/' . $id;
            if (!is_dir($trash_avatars_caminho)) {
                mkdir($trash_avatars_caminho, 0777, true);
            }
            $this->moveDirectory($caminho_imagem, $trash_avatars_caminho);
            if (is_dir($caminho_imagem)) {
                rmdir($caminho_imagem);
            }
            $model->delete($id);
            log_message('alert', "Hunter $primeiro_nome foi enviado(a) para a lixeira.");
            return redirect()->to(route_to('indexHunter'))->with('warning', "Hunter $primeiro_nome foi enviado(a) para a lixeira.");
        } else {
            return redirect()->to(route_to('indexHunter'))->with('error', "Registro de caçador não encontrado.");
        }
    }

    public function logsView()
    {
        $logViewer = new CILogViewer();
        return $logViewer->showLogs();
    }

    public function onlyDeleted()
    {
        $model = new HunterModel();
        $hunters = [
            'hunters' => $model->select('hunters.id, hunters.nome_hunter, 
            hunters.altura_hunter, hunters.idade_hunter, hunters.peso_hunter,
            tipos_hunters.descricao AS descricao_tipo_hunter,
            tipos_nens.descricao AS descricao_tipo_nen,
            tipos_sanguineos.descricao AS descricao_tipo_sanguineo,
            hunters.inicio, hunters.termino')
            ->join('tipos_hunters', 'tipos_hunters.id = hunters.tipo_hunter_id')
            ->join('tipos_nens', 'tipos_nens.id = hunters.tipo_nen_id')
            ->join('tipos_sanguineos', 'tipos_sanguineos.id = hunters.tipo_sangue_id')
            ->onlyDeleted()->paginate(5),
            'pager' => $model->pager,
        ];
        return view('hunter/trash', $hunters);
    }

    public function searchTrash()
    {
        $model = new HunterModel();
        $pesquisa = $this->request->getGet('search');
        $hunters = [
            'hunters' => $model->select('hunters.id, hunters.nome_hunter, 
            hunters.altura_hunter, hunters.idade_hunter, hunters.peso_hunter,
            tipos_hunters.descricao AS descricao_tipo_hunter,
            tipos_nens.descricao AS descricao_tipo_nen,
            tipos_sanguineos.descricao AS descricao_tipo_sanguineo,
            hunters.inicio, hunters.termino')
            ->join('tipos_hunters', 'tipos_hunters.id = hunters.tipo_hunter_id')
            ->join('tipos_nens', 'tipos_nens.id = hunters.tipo_nen_id')
            ->join('tipos_sanguineos', 'tipos_sanguineos.id = hunters.tipo_sangue_id')
            ->like('hunters.nome_hunter', $pesquisa, 'both')
            ->onlyDeleted()->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
        ];
        return view('hunter/trash', $hunters);
    }

    public function restoreDeleted($id)
    {
        $model = new HunterModel();
        $registro_deletado = $model->onlyDeleted()->find($id);
        $nome_hunter = $registro_deletado['nome_hunter'];
        if ($registro_deletado) {
            $model->onlyDeleted()->builder()->update(['deleted_at' => null], ['id' => $id]);
            $caminho_imagem = WRITEPATH . 'uploads/avatars/' . $id;
            $trash_avatars_caminho = WRITEPATH . 'uploads/trash/avatars/' . $id;
            if (is_dir($trash_avatars_caminho)) {
                rename($trash_avatars_caminho, $caminho_imagem);
                if (is_dir($trash_avatars_caminho)) {
                    rmdir($trash_avatars_caminho);
                }
            }
            log_message('info', "Hunter $nome_hunter foi restaurado(a).");
            return redirect()->to(route_to('trashHunter'))->with('success', "Hunter $nome_hunter retornou para a listagem principal.");
        } else {
            return redirect()->to(route_to('trashHunter'))->with('warning', "Hunter $nome_hunter não encontrado(a) ou já restaurado(a).");
        }
    }

    public function deletePermanently($id)
    {
        $model = new HunterModel();
        $recompensado = new RecompensadoModel();
        $registro_deletado = $model->onlyDeleted()->find($id);
        $nome_hunter = $registro_deletado['nome_hunter'];
        $quantidade_hunters = $recompensado->where('hunter_id', $id)->countAllResults();
        if ($quantidade_hunters > 0){
            return redirect()->to(route_to('trashHunter'))->with('warning', "Não é possível excluir $nome_hunter permanentemente, pois está associado em $quantidade_hunters registro(s) de recompensados.");
        }
        $model->onlyDeleted()->where('id', $id)->purgeDeleted();
        $trash_avatars_caminho = WRITEPATH . 'uploads/trash/avatars/' . $id;
        $this->deleteDirectoryContents($trash_avatars_caminho);
        if (is_dir($trash_avatars_caminho)) {
            rmdir($trash_avatars_caminho);
        }
        log_message('alert', "Hunter $nome_hunter foi excluído(a) permanentemente.");
        return redirect()->to(route_to('trashHunter'))->with('danger', "Hunter $nome_hunter foi excluído(a) permanentemente.");
    }

    private function moveDirectory($source, $destination) {
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

    private function deleteDirectoryContents($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file)) { 
                $this->deleteDirectoryContents($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
    }

}