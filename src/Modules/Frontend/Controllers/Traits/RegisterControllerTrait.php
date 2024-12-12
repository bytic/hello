<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use ByTIC\Hello\Models\Users\User;
use Default_Forms_User_Register;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\Record;
use Nip\View;

/**
 * Trait RecoverControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 *
 * @method View getView()
 * @method Record|User _getUser()
 */
trait RegisterControllerTrait
{
    public function index()
    {
        $this->payload()->set('headerTitle', ModelLocator::get('users')->getLabel('register-title'));
        $formRegister = $this->_getUser()->getForm('register');

        /** @var Default_Forms_User_Register $formRegister */
        if ($formRegister->execute()) {
            $this->doSuccessRedirect('register');
        }
        $this->forms['register'] = $formRegister;
        $this->_setMeta('register');
        $this->setLayout('login');
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string
     */
    protected function getRedirectURL()
    {
        return $this->Url()->assemble(
            'frontend.logged_in.thank_you',
            $this->getAuthenticationVariables()
        );
    }
}
