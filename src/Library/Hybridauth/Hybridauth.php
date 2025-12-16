<?php

declare(strict_types=1);

namespace ByTIC\Hello\Library\Hybridauth;

use Exception;
use Hybridauth\Adapter\AdapterInterface;
use Hybridauth\Hybridauth as BaseHybridauth;
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
     * @return Exception|\Hybridauth\User\Profile
     */
    public function authenticate($provider, $params = null)
    {
        try {
            /** @var AdapterInterface $adapter */
            $adapter = $this->getAuth()->authenticate($provider, $params);
            // then grab the user profile
            return $adapter->getUserProfile();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * @return null|BaseHybridauth
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
        $config['callback'] = url()->generate('frontend.o_auth', [], UrlGenerator::ABSOLUTE_URL);
        $this->hybridauth = new BaseHybridauth($config->toArray());
    }
}
