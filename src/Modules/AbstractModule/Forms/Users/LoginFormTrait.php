<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

/**
 * Trait LoginFormTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait LoginFormTrait
{
    public function init()
    {
        parent::init();

        $this->removeClass('form-horizontal');
        $this->addClass('box', 'user-login');

        $this->_trigger->setValue('login');

        $this->addInput('email', translator()->trans('email'), true)
            ->addPassword('password', translator()->trans('password'), true);

        $this->addButton('save', translator()->trans('signin'));
        $this->getButton('save')->addClass('pull-right');
    }

    public function processValidation()
    {
        parent::processValidation();

        $email = $this->getElement('email');
        if (!$email->isError()) {
            $value = $email->getValue();
            if (!valid_email($value)) {
                $email->addError($this->getModelMessage('email.bad'));
            }
        }

        $password = $this->getElement('password');
        if (!$email->isError() && !$password->isError()) {
            $model = $this->getModel();
            $request = ['email' => $email->getValue(), 'password' => $password->getValue()];
            if (!$model->authenticate($request)) {
                $email->addError($this->getModelMessage('login.error'));
            }
        }
    }

    public function process()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function getDataFromModel()
    {
        parent::getDataFromModel();
        $this->_addModelFormMessage('no-email', 'email.empty')
            ->_addModelFormMessage('no-password', 'password.empty');
    }
}