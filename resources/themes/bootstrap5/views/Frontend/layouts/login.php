<?php echo $this->Doctype()->set("XHTML1_STRICT"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php $this->load("/modules/head"); ?>
<body class="page-<?php echo $this->controller; ?>-<?php echo $this->action; ?>">
<?php $this->load('/modules/header-body'); ?>
<?php $this->load('HelloFrontend::/modules/header'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col col-lg-6 col-md-7" >
            <?php $this->render("content"); ?>
        </div>
    </div>
</div>

<?php $this->load('/modules/footer'); ?>
<?php $this->load('/modules/footer-body'); ?>
</body>
</html>