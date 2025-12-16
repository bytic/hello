<?php

declare(strict_types=1);

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use ByTIC\Hello\Models\Users\Logins\Traits\LoginTrait;
use Exception;
use ByTIC\Hello\Library\Hybridauth\Hybridauth;
use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\Locator\ModelLocator;
use Nip\Session\Utility\Session;

/**
 * Trait OAuthControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait OAuthControllerTrait
{
    use AbstractControllerTrait;

    public function index()
    {
        $this->tryHybridauthAuthenticate();
    }

    public function with()
    {
        $this->tryHybridauthAuthenticate();
    }

    public function link()
    {
        $providerName = $this->getRequest()->get('provider');
        $userProfile = Hybridauth::instance()->authenticate($providerName);

        $user = $this->_getUser();
        $user->first_name = $userProfile->firstName;
        $user->last_name = $userProfile->lastName;
        $user->email = $userProfile->email;

        $this->payload()->set('headerTitle', ModelLocator::get('users')->getLabel('o_auth_link.title'));

        foreach (['login', 'register'] as $userAction) {
            $form = $user->getForm($userAction);

            if ($form->execute()) {
                /** @var LoginTrait $userLogin */
                ModelLocator::get('users-logins')
                    ->createForProvider($providerName, $user, $userProfile);

                $this->doSuccessRedirect($userAction);
            }
            $this->forms[$userAction] = $form;
        }

        $this->_setMeta('login');
    }


    protected function tryHybridauthAuthenticate()
    {
        $providerName = $this->getRequest()->get('provider');
        if ($providerName) {
            Session::set('oauth_provider', $providerName);
        }

        $sessionProvider = Session::get('oauth_provider');
        if (!$sessionProvider) {
            $this->redirect($this->Url()->assemble('frontend.login'));
        }

        $userProfile = Hybridauth::instance()->authenticate($providerName);

        if ($userProfile instanceof Exception) {
            $this->payload()->set('exception', $userProfile);
        } else {
            $userExist = ModelLocator::get('users-logins')->getUserByProvider($providerName, $userProfile->identifier);

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
