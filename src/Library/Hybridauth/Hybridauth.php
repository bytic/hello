<?php

namespace ByTIC\Hello\Library\Hybridauth;

use Exception;
use Hybrid_Auth;
use Nip\Records\Locator\ModelLocator;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Hybridauth
 * @package KM42\Hello\Library\Hybridauth
 */
class Hybridauth
{
    use SingletonTrait;

    protected $hybridauth = null;

    /**
     * @param $provider
     * @return Exception
     */
    public function authenticate($provider)
    {
        try {
            // try to authenticate with the selected provider
            $adapter = $this->getAuth()::authenticate($provider);
            // then grab the user profile
            return $adapter->getUserProfile();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return null|Hybrid_Auth
     */
    public function getAuth()
    {
        if ($this->hybridauth === null) {
            $this->initAuth();
        }

        return $this->hybridauth;
    }

    protected function initAuth()
    {
        $config = config('hybridauth');
        $config['base_url'] = ModelLocator::get('users')->getOAuthURL();
        $this->hybridauth = new Hybrid_Auth($config->toArray());
    }
}
