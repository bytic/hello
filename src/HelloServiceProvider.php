<?php

namespace ByTIC\Hello;

use ByTIC\Hello\Utility\CryptHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class HelloServiceProvider
 * @package ByTIC\Auth
 */
class HelloServiceProvider extends AbstractSignatureServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerAuthorizationServer();
    }

    public function registerAuthorizationServer()
    {
        $this->getContainer()->share('hello.server', function () {
            return $this->createAuthorizationServer();
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
            $this->makeCryptKey('private'),
            $this->makeCryptKey('public')
        );

//        $server->enableGrantType(
//            $this->makeAuthCodeGrant(), Passport::tokensExpireIn()
//        );
        return $server;
    }

    /**
     * Build the Auth Code grant instance.
     *
     * @return \League\OAuth2\Server\Grant\AuthCodeGrant
     */
    protected function buildAuthCodeGrant()
    {
        return new AuthCodeGrant(
            $this->getContainer()->make(Bridge\AuthCodeRepository::class),
            $this->getContainer()->make(Bridge\RefreshTokenRepository::class),
            new DateInterval('PT10M')
        );
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['hello.server'];
    }

    /**
     * Create a CryptKey instance without permissions check
     *
     * @param  $type
     * @return \League\OAuth2\Server\CryptKey
     */
    protected function makeCryptKey($type)
    {
        $configKey = null;
        if ($this->getContainer()->has('config')) {
            $configKey = $this->getContainer()->get('config')->get('hello.' . $type . '_key');
        }
        $key = str_replace('\\n', "\n", $configKey);
        if (!$key) {
            $path = CryptHelper::keyPath('oauth-' . $type . '.key');
            if (!file_exists($path)) {
                CryptHelper::generateKeys(dirname($path));
            }
            $key = 'file://' . $path;
        }

        return new CryptKey($key, null, false);
    }
}
