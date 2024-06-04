<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Criar Recompensa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card-body">
    
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('recompensa/index') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
    </div>

    <form method="POST" action="<?= site_url('recompensa/store') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="descricao_recompensa">Descrição:</label>
            <input type="text" class="form-control" name="descricao_recompensa" placeholder="Digite a descrição da recompensa" value="<?= old('descricao_recompensa') ?>">
            <?php echo session()->getFlashdata('errors')["descricao_recompensa"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="valor_recompensa">Valor:</label>
            <input type="text" class="form-control" name="valor_recompensa" placeholder="Digite o valor da recompensa" value="<?= old('valor_recompensa') ?>" onkeypress="$(this).mask('0000000.00', {reverse: true});">
            <?php echo session()->getFlashdata('errors')["valor_recompensa"] ?? "";?>
        </div>
        <br>
        <button type="submit" class="btn btn-success" title="Cadastrar"><i class="fa fa-plus"></i>&nbsp;Cadastrar</button>
    </form>
</div>

<?= $this->endSection() ?>