<?php declare(strict_types=1);
/** @var Frontend_Forms_User_Login $form */
$form = $this->forms['login'];
$renderer = $form->getRenderer();
$showPasswordLabel = translator()->trans('show');
$hidePasswordLabel = translator()->trans('hide');
$passwordLabel = translator()->trans('password');
?>
<?= $renderer->openTag(); ?>
<?= $renderer->renderHidden(); ?>
<?= $renderer->renderRow($form->getElement('email')); ?>
<?php $passwordElement = $form->getElement('password'); ?>
<div class="form-group row-password">
    <div class="d-flex justify-content-end mb-1">
        <a href="<?= $this->Url()->assemble('frontend.recover', $this->authenticationVariables); ?>" class="btn btn-link btn-sm p-0">
            <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('recoverPassword.question'); ?>
        </a>
    </div>
    <?= $renderer->renderLabel($passwordElement); ?>
    <div class="login-password-field">
        <?= $renderer->renderElement($passwordElement); ?>
        <button
                type="button"
                class="btn btn-outline-secondary btn-password-toggle"
                data-password-toggle="true"
                aria-label="<?= $showPasswordLabel . ' ' . $passwordLabel; ?>"
                aria-pressed="false">
            <span class="show-label"><?= $showPasswordLabel; ?></span>
            <span class="hide-label d-none"><?= $hidePasswordLabel; ?></span>
        </button>
    </div>
</div>
<div class="form-group">
    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <a href="<?= $this->Url()->assemble('frontend.register', $this->authenticationVariables); ?>" class="btn btn-link p-0">
            <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('register'); ?>
        </a>
        <?php $buttons = $form->getButtons(); ?>
        <?php foreach ($buttons as $button) { ?>
            <?= $button->render() . "\n"; ?>
        <?php } ?>
    </div>
</div>
<?= $renderer->closeTag(); ?>
