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
        $provider = new HelloServiceProvider();
        $provider->setContainer(new Container());
        $provider->registerAuthorizationServer();

        self::assertInstanceOf(AuthorizationServer::class, $provider->getContainer()->get('hello.server'));
    }

}
