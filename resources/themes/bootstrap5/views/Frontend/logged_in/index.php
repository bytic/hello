<?php declare(strict_types=1);
/** @var User $user */
$user = $this->user;
?>
<div class="card card-default">
    <div class="card-body">
        <h3>Welcome back <?= $user->first_name; ?></h3>
        <p>You have successfully logged in.</p>
        <?= $this->load('modules/redirect'); ?>
        <?= $this->load('/sections/modules/lists/loggedin'); ?>
    </div>
    <div class="card-footer">
        <p>&nbsp;
            <a href="/logout" class="btn btn-default btn-xs pull-right">Logout</a>

            <a href="<?= \Nip\Router\route('frontend.change_password'); ?>" class="btn btn-primary btn-xs">
                <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('password.change'); ?>
            </a>
        </p>
    </div>
</div>