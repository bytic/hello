<?php declare(strict_types=1);
$providers = [
    'facebook' => 'facebook',
    'google' => 'google',
//    'twitter' => 'twitter',
];
?>

<div class="social-auth-btn row">
    <?php foreach ($providers as $provider => $icon) { ?>
        <?php $params = array_merge($this->authenticationVariables, ['provider' => $provider]); ?>
        <div class="col-sm-6">
            <a href="<?= $this->Url()->assemble('frontend.o_auth.with', $params); ?>"
               class="btn btn-sm btn-block btn-social btn-<?= $provider; ?>"
               style="">
                <i class="fa fa-<?= $icon; ?>"></i>
                <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('auth.social'); ?>
                <strong><?= strtoupper($provider); ?></strong>
            </a>
        </div>
    <?php } ?>
</div>
