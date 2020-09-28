<?php

namespace ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\ConfigHelper;
use Mockery as m;
use Nip\Container\Container;

/**
 * Class CryptKeysTraitTest
 * @package ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits
 */
class CryptKeysTraitTest extends AbstractTest
{
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
