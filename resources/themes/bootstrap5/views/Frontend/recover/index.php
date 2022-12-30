<div class="card card-default">
    <div class="card-body">
        <style type="text/css">
            #signup form .help-inline {
                display: none;
            }
        </style>

        <?= $this->Flash()->render($this->controller); ?>

        <?= $this->forms['recover']->render(); ?>

        <a href="<?= $this->Url()->assemble('frontend.login', $this->authenticationVariables); ?>"
           class="btn btn-link pull-right">
            <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('login'); ?>
        </a>

        <a href="<?= $this->Url()->assemble('frontend.register', $this->authenticationVariables); ?>"
           class="btn btn-link ">
            <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('register'); ?>
        </a>
    </div>
</div>