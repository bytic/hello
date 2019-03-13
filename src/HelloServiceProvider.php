<?php

namespace ByTIC\Hello;

use ByTIC\Hello\Utility\CryptHelper;
use League\OAuth2\Server\AuthorizationServer;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use League\OAuth2\Server\CryptKey;

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

    protected function registerAuthorizationServer()
    {
        $this->getContainer()->share('mvc.modules', function () {
            return $this->createAuthorizationServer();
        });
    }

    /**
     * @return AuthorizationServer
     */
    protected function createAuthorizationServer()
    {
        $server = $this->getContainer()->get(AuthorizationServer::class);
        return $server;
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
        $key = str_replace('\\n', "\n", $this->getContainer()->get('config')->get('hello.' . $type . '_key'));
        if (!$key) {
            $key = 'file://' . CryptHelper::keyPath('oauth-' . $type . '.key');
        }
        return new CryptKey($key, null, false);
    }
}
