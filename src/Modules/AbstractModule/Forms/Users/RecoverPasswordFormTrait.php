<?php

namespace ByTIC\Hello\Modules\AbstractModule\Forms\Users;

/**
 * Trait RecoverPasswordFormTrait
 * @package ByTIC\Hello\Modules\AbstractModule\Forms\Users
 */
trait RecoverPasswordFormTrait
{
    public function init()
    {
        parent::init();
        $this->removeClass('form-horizontal');
        $this->addClass('user-recover');

        $this->initEmailInput();

        $this->addButton('save', translator()->trans('submit'));
    }

    protected function initEmailInput()
    {
        $this->addInput('email', translator()->trans('email'), true);
    }

    public function processValidation()
    {
        parent::processValidation();

        $this->processValidationEmail();
    }

    public function processValidationEmail()
    {
        $email = $this->getElement('email');
        if (!$email->isError()) {
            $value = $email->getValue();
            if (!valid_email($value) && false) {
                $email->addError($this->getModelMessage('email.bad'));
            } else {
                $users = $this->getModelManager()->findByEmail($value);
                if (count($users) == 1) {
                    $this->getModel()->email = $value;
                } else {
                    $email->addError($this->getModelMessage('email.dnx'));
                }
            }
        }
    }

    public function process()
    {
        $this->getModel()->recoverPassword();
    }

    protected function getDataFromModel()
    {
        parent::getDataFromModel();
        $this->_addModelFormMessage('no-email', 'email.empty');
    }
}
