<?php

namespace ByTIC\Hello\Tests;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Utility\ConfigHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\AuthorizationServer;
use Mockery as m;
use Nip\Config\Config;
use Nip\Container\Container;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Nip\Records\RecordManager;

/**
 * Class HelloServiceProviderTest
 * @package ByTIC\Hello\Tests
 */
class HelloServiceProviderTest extends AbstractTest
{

    public function testRegisterRepositories()
    {
        $container = new Container();
        $provider = new HelloServiceProvider();
        $provider->setContainer($container);
        $provider->registerRepositories();

        $repositories = [
            AccessTokenRepositoryInterface::class,
            AuthCodeRepositoryInterface::class,
            ClientRepositoryInterface::class,
            RefreshTokenRepositoryInterface::class,
            ScopeRepositoryInterface::class,
//            UserRepositoryInterface::class,
        ];

        foreach ($repositories as $repository) {
            $manager = $container->get($repository);
            self::assertInstanceOf(RecordManager::class, $manager);
            self::assertInstanceOf($repository, $manager);
        }
    }

    public function testRegisterAuthorizationServer()
    {
        $provider = new HelloServiceProvider();
        $provider->setContainer(new Container());
        $provider->registerAuthorizationServer();

        self::assertInstanceOf(AuthorizationServer::class, $provider->getContainer()->get('hello.server'));
    }

    public function testCanUseCryptoKeysFromConfig()
    {
        $config = m::mock(ConfigHelper::class)->makePartial();
        $config->shouldReceive('get')
//            ->with('private_key', null)
            ->andReturn('-----BEGIN RSA PRIVATE KEY-----\nconfig\n-----END RSA PRIVATE KEY-----');

        $provider = new HelloServiceProvider();
        $provider->setContainer(new Container());

        ConfigHelper::setConfig($config);

        // Call protected makeCryptKey method
        $cryptKey = (function () {
            return $this->makeCryptKey('private');
        })->call($provider);

        static::assertSame(
            "-----BEGIN RSA PRIVATE KEY-----\nconfig\n-----END RSA PRIVATE KEY-----",
            file_get_contents($cryptKey->getKeyPath())
        );
    }
}
