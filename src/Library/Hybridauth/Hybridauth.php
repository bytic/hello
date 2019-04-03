<?php

namespace ByTIC\Hello\Library\Hybridauth;

use Exception;
use Hybrid_Auth;
use Nip\Router\Generator\UrlGenerator;
use function Nip\url;
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
     * @return \Hybrid_User_Profile
     */
    public function authenticate($provider, $params = null)
    {
        try {
            /** @var \Hybrid_Provider_Model $adapter */
            $adapter = $this->getAuth()::authenticate($provider, $params);
            // then grab the user profile
            return $adapter->getUserProfile();
        } catch (Exception $e) {
            /** @noinspection PhpIncompatibleReturnTypeInspection */
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
        $config['base_url'] = url()->generate('frontend.o_auth', [], UrlGenerator::ABSOLUTE_URL);
        $this->hybridauth = new Hybrid_Auth($config->toArray());
    }
}
