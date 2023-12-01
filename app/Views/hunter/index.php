<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Listar Hunters
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getFlashdata('success'); ?>
            </div>
        <?php elseif (session()->getFlashdata('info')): ?>
            <div class="alert alert-info" role="alert">
                <?php echo session()->getFlashdata('info'); ?>
            </div>
        <?php elseif (session()->getFlashdata('danger')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo session()->getFlashdata('danger'); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>Listar Hunters
                <a href="<?php echo site_url('hunter/create') ?>" class="btn btn-success mb-2"><i class="fa fa-plus"></i>&nbsp;Add Hunter</a>
                </h4>
            </div>
        </div>

        <form action="<?= site_url('hunter/search') ?>" method="GET" class="form-inline">
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
                        <td><?php echo $h['tipo_hunter_id']; ?></td>
                        <td><?php echo $h['tipo_nen_id']; ?></td>
                        <td><?php echo $h['tipo_sangue_id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($h['inicio'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($h['termino'])); ?></td>
                        <td>
                            <a href="<?php echo base_url('hunter/view/'.$h['id']);?>" class="btn btn-dark btn-sm"><i class="fa fa-eye"></i>&nbsp;Visualizar</a>
                            <a href="<?php echo base_url('hunter/edit/'.$h['id']);?>" class="btn btn-primary btn-sm"><i class="fa fa-arrows-rotate"></i>&nbsp;Atualizar</a>
                            <form method="POST" action="<?php echo base_url('hunter/delete/'.$h['id']);?>">
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
            <?php echo $pager->links() ?>
        </div>
    </div>

<?= $this->endSection() ?>