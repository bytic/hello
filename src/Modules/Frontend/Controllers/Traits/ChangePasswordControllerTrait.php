<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use Frontend_Forms_User_RecoverPassword;
use Nip\Records\Locator\ModelLocator;

trait ChangePasswordControllerTrait
{
    public function index()
    {
        $this->payload()->set(
            'headerTitle',
            ModelLocator::get('users')->getLabel('password.change')
        );

        /** @var Frontend_Forms_User_RecoverPassword $formsRecover */
        $formsRecover = $this->_getUser()->getForm('changePassword');

        if ($formsRecover->execute()) {
//            $redirect = $this->Url()->assemble('frontend.recover', $this->getRequest()->query->all());
            $redirect = $this->Url()->assemble('frontend.change_password');
            $this->flashRedirect($this->_getUser()->getManager()->getMessage('password.change'), $redirect);
        }

        $this->forms['changePassword'] = $formsRecover;
//        $this->_setMeta('changePassword');

        $this->setLayout('login');
    }
}