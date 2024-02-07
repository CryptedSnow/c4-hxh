<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Criar Recompensado
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card-body">
    
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('recompensado/index') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
    </div>

    <form method="POST" action="<?= site_url('recompensado/store') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="recompensa_id">Recompensa:</label>
            <select class="form-control" name="recompensa_id">
                <?php if (empty($recompensas)): ?>
                    <option><?= 'Sem registro de recompensas' ?></option>
                <?php else: ?>
                    <option <?= (old('recompensa_id') == null || old('recompensa_id') == '') ? 'selected' : '' ?> value=""><?= 'Escolha a recompensa' ?></option>
                    <?php foreach ($recompensas as $id => $r): ?>
                        <option <?= old('recompensa_id') == $id ? 'selected' : '' ?> value="<?= $id ?>"><?= $r['descricao_recompensa'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["recompensa_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="hunter_id">Hunter:</label>
            <select class="form-control" name="hunter_id">
                <?php if (empty($hunters)): ?>
                    <option><?= 'Sem registro de Hunters' ?></option>
                <?php else: ?>
                    <option <?= (old('hunter_id') == null || old('hunter_id') == '') ? 'selected' : '' ?> value=""><?= 'Escolha o Hunter' ?></option>
                    <?php foreach ($hunters as $id => $h): ?>
                        <option <?= old('hunter_id') == $id ? 'selected' : '' ?> value="<?= $id ?>"><?= $h['nome_hunter'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["hunter_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="concluida">Status:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" role="switch" name="concluida" <?= (old('concluida') == true) ? 'checked' : '' ?>>
                <label class="form-check-label" for="concluida">Concluída</label>
            </div>  
            <?php echo session()->getFlashdata('errors')["concluida"] ?? ""; ?>
        </div>
        <br>
        <button type="submit" class="btn btn-success" title="Cadastrar"><i class="fa fa-plus"></i>&nbsp;Cadastrar</button>
    </form>
</div>

<?= $this->endSection() ?>