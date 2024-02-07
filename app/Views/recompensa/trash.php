<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Listar Recompensas Excluídas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card-body">

        <div class="card">
            <div class="card-header">
                <h4>Lixeira de Recompensas
                    <a href="<?php echo site_url('recompensa/index') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a> 
                </h4>
            </div>
        </div>

        <form action="<?= site_url('recompensa/search-trash') ?>" method="GET" class="form-inline">
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
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recompensas as $r): ?>
                    <tr>
                        <td><?php echo $r['descricao_recompensa']; ?></td>
                        <td>R$ <?php echo number_format($r['valor_recompensa'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="<?php echo base_url('recompensa/restore/'.$r['id']);?>" class="btn btn-primary btn-sm"><i class="fa fa-arrows-rotate"></i>&nbsp;Restaurar</a>
                            <form method="POST" action="<?php echo base_url('recompensa/delete-permantently/'.$r['id']);?>">
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