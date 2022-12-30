<h3><?= translator()->trans('general.errors.500.title'); ?></h3>

<?= $this->Messages()->error($this->exception->getMessage()); ?>

<?php if (app('staging')->getStage()->inTesting()) { ?>
    <?= $this->Messages()->info('<pre>' . $this->exception->__toString() . '</pre>'); ?>
<?php } ?>
