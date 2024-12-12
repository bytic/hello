<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use ByTIC\Hello\Models\Users\User;
use ByTIC\Hello\Modules\AbstractModule\Forms\Users\RecoverPasswordFormTrait;
use Nip\Form\Form;
use Nip\Records\Record;
use Nip\View;

/**
 * Trait RecoverControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 *
 * @method View getView()
 * @method Record|User _getUser()
 */
trait RecoverControllerTrait
{
    public function index()
    {
        $this->getView()->set('headerTitle', $this->_getUser()->getManager()->getLabel('recoverPassword'));

        /** @var RecoverPasswordFormTrait|Form $formsRecover */
        $formsRecover = $this->_getUser()->getForm('recoverPassword');

        if ($formsRecover->execute()) {
            $redirect = $this->Url()->assemble('frontend.recover', $this->getRequest()->query->all());
            $this->flashRedirect($this->getModelManager()->getMessage('recoverPassword.success'), $redirect);
        }

        $this->forms['recover'] = $formsRecover;
        $this->_setMeta('recoverPassword');
        $this->setLayout('login');
    }
}
