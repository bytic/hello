<?php

namespace ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Oauth\Grants\PersonalAccessGrant;
use ByTIC\Hello\Tests\AbstractTest;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use Mockery;
use Nip\Container\Container;

/**
 * Class GrantsTraitTest
 * @package ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits
 */
class GrantsTraitTest extends AbstractTest
{

    public function testMakeGrantPersonalAccess()
    {
        $container = new Container();

        /** @var Mockery\Mock|HelloServiceProvider $provider */
        $provider = \Mockery::mock(HelloServiceProvider::class)
            ->makePartial()->shouldAllowMockingProtectedMethods();

        $provider->shouldReceive('getRegisteredGrants')
            ->andReturn(['PersonalAccess' => PersonalAccessGrant::class]);

        $provider->shouldReceive('createAuthorizationServer')->andReturn(\Mockery::mock(AuthorizationServer::class));
        
        $provider->shouldReceive('makeCryptKey')
            ->andReturn(new CryptKey("-----BEGIN RSA PRIVATE KEY-----\nconfig\n-----END RSA PRIVATE KEY-----",null, false));

        $provider->shouldReceive('makeGrantPersonalAccess')->once();

        $provider->setContainer($container);
        $provider->registerAuthorizationServer();

        $server = $container->get('hello.server');
        self::assertInstanceOf(AuthorizationServer::class, $server);
    }
}
