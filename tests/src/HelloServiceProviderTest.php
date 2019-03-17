<?php

namespace ByTIC\Hello\Tests;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Utility\ConfigHelper;
use League\OAuth2\Server\AuthorizationServer;
use Mockery as m;
use Nip\Config\Config;
use Nip\Container\Container;

/**
 * Class HelloServiceProviderTest
 * @package ByTIC\Hello\Tests
 */
class HelloServiceProviderTest extends AbstractTest
{

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
