<div class="card card-default">
    <div class="card-body">
        <?= $this->Flash()->render($this->controller); ?>

        <?= $this->forms['changePassword']->render(); ?>
    </div>
</div>