<?php

declare(strict_types=1);

use Nip\Records\Locator\ModelLocator;

/**
 * Class Frontend_Forms_User_Register.
 *
 * @method User getModel
 */
trait RegisterFormTrait
{
    public function init()
    {
        parent::init();
        $this->initRegisterForm();
    }

    protected function initRegisterForm() {
        $this->removeClass('form-horizontal');
        $this->addClass('box', 'user-register');

        $this->_trigger->setValue('register');

        $this->intiRegisterFormBaseFields();
        $this->initRegisterFormTosField();
        $this->initRegisterFormNewsletterField();
        $this->initRegisterFormRecapcha();

        $this->addButton('save', translator()->trans('submit'));
    }

    public function processValidation()
    {
        parent::processValidation();

        $this->validateEmail();
        $this->validateDuplicatePassword();
    }

    public function process()
    {
        $this->processRegistration();
        $this->processNewsletter();

        return true;
    }

    protected function processRegistration()
    {
        $this->saveToModel();

        $this->getModel()->register();
        $this->getModel()->doAuthentication();
    }

    protected function getDataFromModel()
    {
        parent::getDataFromModel();
        $this->_addModelFormMessage('no-first_name', 'first_name.empty')
            ->_addModelFormMessage('no-last_name', 'last_name.empty')
            ->_addModelFormMessage('no-email', 'email.empty')
            ->_addModelFormMessage('no-password', 'password.empty')
            ->_addModelFormMessage('no-password_repeat', 'password_repeat.empty')
            ->_addModelFormMessage('no-tos', 'no-tos');
    }

    /**
     * @return void
     */
    protected function validateDuplicatePassword(): void
    {
        $password = $this->getElement('password');
        $password_repeat = $this->getElement('password_repeat');
        if (!$password->isError() && !$password_repeat->isError()) {
            if ($password->getValue() != $password_repeat->getValue()) {
                $password->addError($this->getModelMessage('password.match'));
            }
        }
    }

    /**
     * @return void
     */
    protected function validateEmail(): void
    {
        $element = 'email';
        $formEl = $this->getElement($element);
        if (!$formEl->isError()) {
            $value = $formEl->getValue();
            if (!valid_email($value)) {
                $formEl->addError($this->getModelMessage($element . '.bad'));
            } else {
                $this->getModel()->email = $value;
                if ($this->getModel()->exists()) {
                    $formEl->addError($this->getModelMessage($element . '.exists'));
                }
            }
        }
    }

    /**
     * @return void
     */
    protected function intiRegisterFormBaseFields(): void
    {
        $this->addInput('first_name', translator()->trans('first_name'), true)
            ->addInput('last_name', translator()->trans('last_name'), true)
            ->addInput('email', translator()->trans('email'), true)
            ->addPassword('password', translator()->trans('password'), true)
            ->addPassword('password_repeat', translator()->trans('password_repeat'), true);
    }

    /**
     * @return void
     */
    protected function initRegisterFormTosField(): void
    {
        $tosLabel = ModelLocator::get('users')->getLabel('tos');
        $this->addCheckbox('tos', '', true);

        $tosElement = $this->getElement('tos');
        $tosElement->setOption('render_label', false);
        $tosElement->setAttrib('title', strip_tags($tosLabel));
        $tosElement->setLabel($tosLabel);
    }

    /**
     * @return void
     */
    protected function initRegisterFormNewsletterField(): void
    {
    }

    /**
     * @return mixed
     */
    protected function initRegisterFormRecapcha()
    {
        return $this->add('g-recaptcha-response', 'recaptcha', 'recaptcha', true);
    }

    /**
     * @return void
     */
    protected function processNewsletter(): void
    {
    }
}
