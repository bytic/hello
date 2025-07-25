<?php

namespace ByTIC\Hello\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\Utility\ConfigHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use Defuse\Crypto\Key;
use League\OAuth2\Server\AuthorizationServer;

/**
 * Trait AuthorizationServerTrait
 * @package ByTIC\Hello\Oauth\ServiceProvider\Traits
 */
trait AuthorizationServerTrait
{
    use GrantsTrait;
    use CryptKeysTrait;

    public function registerAuthorizationServer()
    {
        $this->registerCryptKeys();

        $this->getContainer()->alias('hello.server', AuthorizationServer::class);

        $this->getContainer()->share('hello.server', function () {
            $server = $this->createAuthorizationServer();
            $this->registerGrants($server);
            return $server;
        });
    }

    /**
     * @return AuthorizationServer
     */
    protected function createAuthorizationServer()
    {
        $encriptionKeyString = ConfigHelper::get('encryption_key');
        if (empty($encriptionKeyString)) {
            throw new \RuntimeException('Hello encryption key is not set in the configuration.');
        }

        $encriptionKey = Key::loadFromAsciiSafeString($encriptionKeyString);

        $server = new AuthorizationServer(
            ModelsHelper::clients(),
            ModelsHelper::accessTokens(),
            ModelsHelper::scopes(),
            $this->getContainer()->get('hello.keys.private'),
            $encriptionKey
        );

        return $server;
    }
}
