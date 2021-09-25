<?php

namespace ByTIC\Hello\Modules\AbstractModule\Forms\Users;

/**
 * Trait ChangePasswordFormTrait
 * @package ByTIC\Hello\Modules\AbstractModule\Forms\Users
 *
 * @method getModel
 */
trait ChangePasswordFormTrait
{
    public function init()
    {
        parent::init();
        $this->removeClass('form-horizontal');
        $this->addClass('user-recover');

        $this->initPasswordOld();
        $this->initPasswordNew();
        $this->initPasswordRepeat();

        $this->addButton('save', translator()->trans('submit'));
    }

    protected function initPasswordOld()
    {
        $this->addPassword('password_old', translator()->trans('password_old'), true);
    }

    protected function initPasswordNew()
    {
        $this->addPassword('password_new', translator()->trans('password_new'), true);
    }

    protected function initPasswordRepeat()
    {
        $this->addPassword('password_repeat', translator()->trans('password_repeat'), true);
    }

    public function processValidation()
    {
        parent::processValidation();

        $this->processValidationPasswordOld();
        $this->processValidationPasswordNew();
    }

    public function processValidationPasswordOld()
    {
        $passwordOld = $this->getElement('password_old');
        if ($passwordOld->isError()) {
            return;
        }

        $hashCheck = $this->getModel()->checkSaltedPassword($passwordOld->getValue());
        if ($hashCheck === false) {
            $passwordOld->addError($this->getModelMessage('password_old.bad'));
        }
    }

    public function processValidationPasswordNew()
    {
        $password = $this->getElement('password_new');
        $password_repeat = $this->getElement('password_repeat');
        if (!$password->isError() && !$password_repeat->isError()) {
            if ($password->getValue() == $password_repeat->getValue()) {
                $this->changePassword = true;
            } else {
                $password->addError($this->getModelMessage('password.match'));
            }
        }
    }

    public function process()
    {
        $this->getModel()->new_password = $this->getElement('password_new')->getValue();
        $this->getModel()->hashPassword();
        $this->getModel()->update();

        return true;
    }

    protected function getDataFromModel()
    {
        parent::getDataFromModel();
        $this->_addModelFormMessage('no-password_old', 'password_old.empty')
            ->_addModelFormMessage('no-password_new', 'password_new.empty')
            ->_addModelFormMessage('no-password_repeat', 'password_repeat.empty');
    }
}
