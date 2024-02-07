<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Listar Recompensados
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card-body">

        <div class="card">
            <div class="card-header">
                <h4>Listar Hunters
                    <a href="<?php echo site_url('/') ?>" class="btn btn-info float-center"><i class="fa fa-image-portrait"></i>&nbsp;Hunters</a>
                    <a href="<?php echo site_url('recompensa/index') ?>" class="btn btn-dark float-center"><i class="fa fa-sack-dollar"></i>&nbsp;Recompensas</a>
                    <a href="<?php echo site_url('recompensado/create') ?>" class="btn btn-success float-center"><i class="fa fa-plus"></i>&nbsp;Add Recompensado</a>
                    <a href="<?php echo site_url('recompensado/trash') ?>" class="btn btn-danger float-center"><i class="fa fa-dumpster"></i>&nbsp;Lixeira de recompensados</a>
                </h4>
            </div>
        </div>

        <form action="<?= site_url('recompensado/search') ?>" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Filtrar por nome">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-magnifying-glass"></i></i>&nbsp;Filtrar</button>
                    </div>
            </div>
        </form>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Recompensa</th>
                    <th>Valor</th>
                    <th>Recompensado</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recompensados as $r): ?>
                    <tr>
                        <td><?php echo $r['descricao_recompensa']; ?></td>
                        <td>R$ <?php echo number_format($r['valor_recompensa'], 2, ',', '.'); ?></td>
                        <td><?php echo $r['nome_hunter']; ?></td>
                        <td><?php echo $r['concluida'] ? 'Concluída' : 'Não Concluída'; ?></td>
                        <td>
                            <a href="<?php echo base_url('recompensado/view/'.$r['id']);?>" class="btn btn-dark btn-sm"><i class="fa fa-eye"></i>&nbsp;Visualizar</a>
                            <form method="POST" action="<?php echo base_url('recompensado/delete/'.$r['id']);?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Deletar</button>
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