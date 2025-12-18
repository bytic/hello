<?php

declare(strict_types=1);

use Nip\Records\Locator\ModelLocator;

?>
<div id="signup" class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card card-default">
                <div class="card-body">
                    <h3><?= translator()->trans('oauth.error.title'); ?></h3>

                    <?= $this->Messages()->error($this->exception->getMessage()); ?>

                    <div class="">
                        <a href="<?= $this->Url()->assemble('frontend.register', $this->authenticationVariables); ?>"
                           class="btn btn-primary">
                            <?= ModelLocator::get('users')->getLabel('register'); ?>
                        </a>
                        <a href="<?= $this->Url()->assemble('frontend.login', $this->authenticationVariables); ?>"
                           class="btn btn-secondary">
                            <?= ModelLocator::get('users')->getLabel('login'); ?>
                        </a>
                    </div>

                    <?php
                    if (app('staging')->getStage()->inTesting()) { ?>
                        <?= $this->Messages()->info('<pre>' . $this->exception->__toString() . '</pre>'); ?>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
