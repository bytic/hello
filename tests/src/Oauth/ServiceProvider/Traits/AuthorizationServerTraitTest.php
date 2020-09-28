<?php

namespace ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\ConfigHelper;
use League\OAuth2\Server\AuthorizationServer;
use Mockery as m;
use Nip\Container\Container;

/**
 * Class AuthorizationServerTraitTest
 * @package ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits
 */
class AuthorizationServerTraitTest extends AbstractTest
{
    public function testRegisterAuthorizationServer()
    {
        /** @var m\Mock|HelloServiceProvider $provider */
        $provider = \Mockery::mock(HelloServiceProvider::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $provider->shouldReceive('createAuthorizationServer')->andReturn(\Mockery::mock(AuthorizationServer::class));
        $provider->shouldReceive('registerGrants');

        $container = new Container();
        $provider->setContainer($container);
        $provider->registerAuthorizationServer();

        self::assertInstanceOf(AuthorizationServer::class, $container->get('hello.server'));
    }
}
