<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use Exception;
use Hybrid_Endpoint;
use ByTIC\Hello\Library\Hybridauth\Hybridauth;
use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Trait OAuthControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait OAuthControllerTrait
{
    use AbstractControllerTrait;
    /**
     * @return Hybrid_Endpoint
     */
    public function index()
    {
        return Hybrid_Endpoint::process();
    }

    public function link()
    {
        $providerName = $_REQUEST["provider"];
        $userProfile = Hybridauth::instance()->authenticate($providerName);

        $this->_getUser()->first_name = $userProfile->firstName;
        $this->_getUser()->last_name = $userProfile->lastName;
        $this->_getUser()->email = $userProfile->email;

        $this->getView()->set('headerTitle', ModelLocator::get('users')->getLabel('o_auth_link.title'));

        foreach (['login', 'register'] as $userAction) {
            $form = $this->_getUser()->getForm($userAction);

            if ($form->execute()) {
                $userLogin = ModelLocator::get('User_Logins')->getNew();
                $userLogin->id_user = $this->_getUser()->id;
                $userLogin->provider_name = $providerName;
                $userLogin->provider_uid = $userProfile->identifier;
                $userLogin->insert();

                $this->doSuccessRedirect($userAction);
            }
            $this->forms[$userAction] = $form;
        }

        $this->_setMeta('login');
    }

    public function with()
    {
        $providerName = $this->getRequest()->get('provider');
        $userProfile = Hybridauth::instance()->authenticate($providerName);

        if ($userProfile instanceof Exception) {
            $this->getView()->set('exception', $userProfile);
        } else {
            $userExist = ModelLocator::get('User_Logins')->getUserByProvider($providerName, $userProfile->identifier);

            if (!$userExist) {
                $this->redirect($this->Url()->assemble(
                    'frontend.o_auth.link',
                    [
                        'provider' => $providerName,
                        'redirect' => $this->getRedirectURL(),
                    ]
                ));
            }

            $userExist->doAuthentication();
            $this->doSuccessRedirect();
        }
    }
}
