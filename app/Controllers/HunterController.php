<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;
use App\Models\{AvatarHunterModel,HunterModel,RecompensadoModel,TipoHunterModel,TipoSanguineoModel,TipoNenModel};
use App\Validation\HunterValidation;
use CILogViewer\CILogViewer;
use ZipArchive;

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
            $caminho_diretorio = WRITEPATH . 'uploads/avatars/' . $id;
            if (is_dir($caminho_diretorio)) {
                $files = glob($caminho_diretorio . '/*'); 
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            } else {
                mkdir($caminho_diretorio, 0777, true);
            }
            foreach ($this->request->getFileMultiple('avatar') as $avatar) {
                $nome_original = $avatar->getName();
                $caminho_imagem = 'uploads/avatars/' . $id . '/' . $nome_original;
                $avatar->move($caminho_diretorio, $nome_original);
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
            $model->moveDirectory($caminho_imagem, $trash_avatars_caminho);
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
        $model->deleteDirectoryContents($trash_avatars_caminho);
        if (is_dir($trash_avatars_caminho)) {
            rmdir($trash_avatars_caminho);
        }
        log_message('alert', "Hunter $nome_hunter foi excluído(a) permanentemente.");
        return redirect()->to(route_to('trashHunter'))->with('danger', "Hunter $nome_hunter foi excluído(a) permanentemente.");
    }

    public function downloadZip($id)
    {
        $model = new HunterModel();
        $avatar_hunter_model = new AvatarHunterModel();
        $nome = $model->find($id);
        if (!$nome) {
            return "Registro não encontrado.";
        }
        $nome_hunter = $nome['nome_hunter'];
        $nome_zip = "Hunter {$nome_hunter}.zip";
        $zip_caminho = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nome_zip;
        $zip_archive = new ZipArchive();
        if ($zip_archive->open($zip_caminho, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = $avatar_hunter_model->getAvatarFiles($id);
            if (empty($files)) {
                return "Nenhum arquivo de avatar encontrado para o ID {$id}.";
            }
            foreach ($files as $file) {
                $file_path = $file['path'];
                $file_name = basename($file_path);
                if (strtolower($file_name) === 'index.html') {
                    continue;
                }
                $zip_archive->addFile($file_path, $file_name);
            }
            $zip_archive->close();
            if (file_exists($zip_caminho)) {
                $response = new Response(null, 200);
                $response->setContentType('application/octet-stream');
                $response->setHeader('Content-Disposition', 'attachment; filename="' . $nome_zip . '"');
                $response->setHeader('Content-Length', filesize($zip_caminho));
                $response->setBody(file_get_contents($zip_caminho));
                unlink($zip_caminho);
                return $response;
            } else {
                return "O arquivo zip não foi encontrado.";
            }
        } else {
            return "Não foi possível criar o arquivo zip para os arquivos de {$nome_hunter}.";
        }
    }

    public function downloadTrashZip($id)
    {
        $model = new HunterModel();
        $avatar_hunter_model = new AvatarHunterModel();
        $nome = $model->onlyDeleted()->find($id);
        if (!$nome) {
            return "Registro não encontrado.";
        }
        $nome_hunter = $nome['nome_hunter'];
        $nome_zip = "Hunter {$nome_hunter}.zip";
        $zip_caminho = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nome_zip;
        $zip_archive = new ZipArchive();
        if ($zip_archive->open($zip_caminho, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = $avatar_hunter_model->getAvatarTrashFiles($id);
            if (empty($files)) {
                return "Nenhum arquivo de avatar encontrado para o ID {$id}.";
            }
            foreach ($files as $file) {
                $file_path = $file['path'];
                $file_name = basename($file_path);
                if (strtolower($file_name) === 'index.html') {
                    continue;
                }
                $zip_archive->addFile($file_path, $file_name);
            }
            $zip_archive->close();
            if (file_exists($zip_caminho)) {
                $response = new Response(null, 200);
                $response->setContentType('application/octet-stream');
                $response->setHeader('Content-Disposition', 'attachment; filename="' . $nome_zip . '"');
                $response->setHeader('Content-Length', filesize($zip_caminho));
                $response->setBody(file_get_contents($zip_caminho));
                unlink($zip_caminho);
                return $response;
            } else {
                return "O arquivo zip não foi encontrado.";
            }
        } else {
            return "Não foi possível criar o arquivo zip para os arquivos de {$nome_hunter}.";
        }
    }

}