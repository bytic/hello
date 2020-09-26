<?php echo $this->Doctype()->set("XHTML1_STRICT"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php $this->load("/modules/head"); ?>
<body class="page-<?php echo $this->controller; ?>-<?php echo $this->action; ?>">
<?php $this->load('/modules/header-body'); ?>
<?php $this->load('/modules/header'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" >
            <?php $this->render("content"); ?>
        </div>
    </div>
</div>

<?php $this->load('/modules/footer'); ?>
<?php $this->load('/modules/footer-body'); ?>
</body>
</html>