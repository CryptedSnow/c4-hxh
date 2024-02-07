<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap.min.css')?>">
    <script src="<?= base_url('assets/bootstrap.bundle.min.js')?>"></script>
    <script src="<?= base_url('assets/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/pooper.min.js')?>"></script>
    <script src="<?= base_url('assets/jquery-3.7.1.slim.js')?>"></script>
    <script src="<?= base_url('assets/font-awesome.js')?>"></script>
    <title><?= $this->renderSection('title')?></title>
</head>
<body>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('info'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('danger')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('danger'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('warning'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>

    <footer class="container">
        <div class="row">
            <div class="col text-center">
                <em> Iury Fernandes, <?php echo date('Y'); ?>.</em>
            </div>
        </div>
    </footer>
    
</body>
</html>