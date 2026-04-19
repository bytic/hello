<?= $this->Doctype()->set("XHTML1_STRICT"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?= $this->load("/modules/head"); ?>
<body class="page-<?php echo $this->controller; ?>-<?php echo $this->action; ?>">
<?= $this->load('/modules/header-body'); ?>
<?= $this->load('HelloFrontend::/modules/header'); ?>

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4">
            <?= $this->render("content"); ?>
        </div>
    </div>
</div>

<?= $this->load('/modules/footer'); ?>
<?= $this->load('/modules/footer-body'); ?>
</body>
</html>
