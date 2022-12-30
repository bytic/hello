<?php declare(strict_types=1);
/** @var Frontend_Forms_User_Login $form */
$form = $this->forms['login'];
$renderer = $form->getRenderer();
?>
<?= $renderer->openTag(); ?>
<?= $renderer->renderHidden(); ?>
<?= $renderer->renderRow($form->getElement('email')); ?>
<?php $passwordElement = $form->getElement('password'); ?>
<div class="form-group row-password">
    <a href="<?= $this->Url()->assemble('frontend.recover', $this->authenticationVariables); ?>" class="btn btn-link btn-xs pull-right"
       style="margin-top: -4px">
        <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('recoverPassword.question'); ?>
    </a>
    <?= $renderer->renderLabel($passwordElement); ?>
    <?= $renderer->renderElement($passwordElement); ?>
</div>
<div class="form-group">
    <div class="">
        <a href="<?= $this->Url()->assemble('frontend.register', $this->authenticationVariables); ?>" class="btn btn-link">
            <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('register'); ?>
        </a>
        <?php $buttons = $form->getButtons(); ?>
        <?php foreach ($buttons as $button) { ?>
            <?= $button->render() . "\n"; ?>
        <?php } ?>
    </div>
</div>
<?= $renderer->closeTag(); ?>
