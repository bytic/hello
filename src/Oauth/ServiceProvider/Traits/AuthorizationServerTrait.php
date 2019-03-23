<?php

namespace ByTIC\Hello\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\Utility\ModelsHelper;
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
        $server = new AuthorizationServer(
            ModelsHelper::clients(),
            ModelsHelper::accessTokens(),
            ModelsHelper::scopes(),
            $this->getContainer()->get('hello.keys.private'),
            $this->getContainer()->get('hello.keys.public')
        );

        return $server;
    }
}
