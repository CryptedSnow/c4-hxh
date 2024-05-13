<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Listar Hunters Excluídos
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card-body">

        <div class="card">
            <div class="card-header">
                <h4>Lixeira de Hunters
                    <a href="<?php echo site_url('/') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a> 
                </h4>
            </div>
        </div>

        <form action="<?= site_url('hunter/search-trash') ?>" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Filtrar por descrição">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-magnifying-glass"></i></i>&nbsp;Filtrar</button>
                    </div>
            </div>
        </form>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Altura</th>
                    <th>Peso</th>
                    <th>Tipo de Hunter</th>
                    <th>Tipo de Nen</th>
                    <th>Tipo sanguíneo</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($hunters as $h): ?>
                    <tr>
                        <td><?php echo $h['nome_hunter']; ?></td>
                        <td><?php echo $h['idade_hunter']; ?></td>
                        <td><?php echo $h['altura_hunter']; ?> m</td>
                        <td><?php echo $h['peso_hunter']; ?> kg</td>
                        <td><?php echo $h['descricao_tipo_hunter']; ?></td>
                        <td><?php echo $h['descricao_tipo_nen']; ?></td>
                        <td><?php echo $h['descricao_tipo_sanguineo']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($h['inicio'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($h['termino'])); ?></td>
                        <td>
                            <a href="<?php echo base_url('hunter/restore/'.$h['id']);?>" class="btn btn-primary btn-sm"><i class="fa fa-arrows-rotate"></i>&nbsp;Restaurar</a>
                            <a href="<?php echo base_url('hunter/download-zip-trash/'.$h['id']);?>" class="btn btn-warning btn-sm"><i class="fa fa-file-zipper"></i>&nbsp;Download</a>
                            <form method="POST" action="<?php echo base_url('hunter/delete-permantently/'.$h['id']);?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <!-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Deletar</button> -->
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <?php echo $pager->links('default', 'pagination') ?>
        </div>
    </div>

<?= $this->endSection() ?>