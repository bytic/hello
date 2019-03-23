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
use Nip\Request;
use Nip\Router\Router;

/**
 * Class HelloServiceProviderTest
 * @package ByTIC\Hello\Tests
 */
class HelloServiceProviderTest extends AbstractTest
{
    public function testBoot()
    {
        $container = new Container();
        $provider = new HelloServiceProvider();
        $provider->setContainer($container);

        $router = new Router();
        $container->set('router', $router);

        $provider->boot();

        $routes = $router->getRoutes();
        self::assertCount(1, $routes);

        self::assertTrue($routes->has('oauth.keys'));

        $request = Request::create('/oauth/keys');
        self::assertSame(
            [
                'controller' => 'ByTIC\Hello\Modules\Oauth\Controllers\KeysController',
                'action' => 'index',
                '_route' => 'oauth.keys'
            ],
            $router->matchRequest($request)
        );
    }
}
