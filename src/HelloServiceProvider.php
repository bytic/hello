<?php

namespace ByTIC\Hello;

use ByTIC\Hello\Oauth\ServiceProvider\Traits\GrantsTrait;
use ByTIC\Hello\Utility\ConfigHelper;
use ByTIC\Hello\Utility\CryptHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class HelloServiceProvider
 * @package ByTIC\Auth
 */
class HelloServiceProvider extends AbstractSignatureServiceProvider
{
    use GrantsTrait;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerAuthorizationServer();
    }

    public function registerRepositories()
    {
        $repositories = ModelsHelper::repositories();
        foreach ($repositories as $interface => $class) {
            $this->getContainer()->alias($class, $interface);
        }
    }

    public function registerAuthorizationServer()
    {
        $this->getContainer()->alias('hello.server', AuthorizationServer::class);

        $this->getContainer()->share('hello.server', function () {
            $server = $this->createAuthorizationServer();
            $this->registerGrants($server);
            return $server;
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        $return = [
            'hello.server',
            AuthorizationServer::class
        ];

        $repositories = ModelsHelper::repositories();
        foreach ($repositories as $interface => $class) {
            $return[] = $interface;
        }

        return $return;
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

        return $server;
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
        $configKey = ConfigHelper::get($type . '_key');

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
