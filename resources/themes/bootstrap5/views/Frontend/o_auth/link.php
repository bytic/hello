<?php declare(strict_types=1);
echo $this->Messages()->info(
    \Nip\Records\Locator\ModelLocator::get('users')->getMessage('o_auth_link', ['provider' => $_GET['provider']])
); ?>

<div id="signup">
    <div class="card card-default">
        <div class="card-body">

            <style type="text/css">
                form .message-error {
                    display: none;
                }
            </style>

            <h3 class="social-auth-title">
                <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('o_auth_link.login'); ?>
            </h3>
            <?= $this->forms['login']->render(); ?>
            <br clear="all">
            <hr/>

            <h3 class="social-auth-title">
                <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('o_auth_link.register'); ?>
            </h3>

            <?= $this->forms['register']->render(); ?>
        </div>
    </div>
</div>