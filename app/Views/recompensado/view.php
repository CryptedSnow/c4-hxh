<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Visualizar Recompensa <?php echo $recompensados['id']; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card-body">
    
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('recompensado/index') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
    </div>

    <form>
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="recompensa_id">Recompensa:</label>
            <select class="form-control" name="recompensa_id" disabled>
                <?php if (empty($recompensas)): ?>
                    <option><?= 'Sem registros de recompensas' ?></option>
                <?php else: ?>
                    <option <?= (empty($recompensados['recompensa_id'])) ? 'selected' : '' ?> value=""><?= 'Escolha a recompensa' ?></option>
                    <?php foreach ($recompensas as $id => $r): ?>
                        <option <?= ($recompensados['recompensa_id'] == $id) ? 'selected' : '' ?> value="<?= $id ?>"><?= $r['descricao_recompensa'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["recompensa_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="hunter_id">Hunter:</label>
            <select class="form-control" name="hunter_id" disabled>
                <?php if (empty($hunters)): ?>
                    <option><?= 'Sem registros de Hunters' ?></option>
                <?php else: ?>
                    <option <?= (empty($recompensados['hunter_id'])) ? 'selected' : '' ?> value=""><?= 'Escolha o Hunter' ?></option>
                    <?php foreach ($hunters as $id => $h): ?>
                        <option <?= ($recompensados['hunter_id'] == $id) ? 'selected' : '' ?> value="<?= $id ?>"><?= $h['nome_hunter'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["hunter_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="concluida">Status:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="concluida" <?= $recompensados['concluida'] == true ? 'checked' : '' ?> disabled>
                <label class="form-check-label" for="concluida">Concluída</label>
            </div>  
            <?php echo session()->getFlashdata('errors')["concluida"] ?? ""; ?>
        </div>
        <br>
    </form>
</div>

<?= $this->endSection() ?>