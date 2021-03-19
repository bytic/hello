<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <span class="glyphicon glyphicon-list"></span>

            <?php echo translator()->trans('details'); ?>
        </h4>
        <a href="<?php echo $this->item->compileURL('edit'); ?>" class="pull-right btn btn-primary btn-xs">
            Edit
        </a>
    </div>
    <?php echo $this->load("../item/details"); ?>
</div>