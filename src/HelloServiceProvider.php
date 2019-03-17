<?php

namespace ByTIC\Hello;

use ByTIC\Hello\Utility\ConfigHelper;
use ByTIC\Hello\Utility\CryptHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
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
        $this->registerRepositories();
        $this->registerAuthorizationServer();
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
     * @param AuthorizationServer $server
     */
    protected function registerGrants(AuthorizationServer $server)
    {
        $grantTypes = ConfigHelper::get('grant_types', []);
        foreach ($grantTypes as $type => $class) {
            $method = 'makeGrant' . $type;
            $this->{$method}($server, $class);
        }
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantAuthCode(AuthorizationServer $server, string $class)
    {
        $this->makeGrant(
            $server,
            $class,
            [
                $this->getContainer()->get(AuthCodeRepositoryInterface::class),
                $this->getContainer()->get(RefreshTokenRepositoryInterface::class),
                ConfigHelper::get('token_ttl')
            ]
        );
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantRefreshToken(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            $this->getContainer()->get(RefreshTokenRepositoryInterface::class)
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantPassword(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            $this->getContainer()->get(UserRepositoryInterface::class),
            $this->getContainer()->get(RefreshTokenRepositoryInterface::class)
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantImplicit(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            ConfigHelper::get('token_ttl')
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantClientCredentials(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, []);
    }

    /**
     * @param AuthorizationServer $server
     * @param string|null $type
     * @param array $args
     */
    protected function makeGrant(AuthorizationServer $server, string $type, array $args)
    {
        if ($type !== null) {
            $grant = new $type(...$args);
            if ($type !== null && $grant !== null) {
                $server->enableGrantType($grant);
            }
        }
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

    protected function registerRepositories()
    {
        $repositories = ModelsHelper::repositories();
        foreach ($repositories as $interface => $class) {
            $this->getContainer()->alias($class, $interface);
        }
    }
}
