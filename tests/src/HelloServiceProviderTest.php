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
use Nip\Router\Route\Route;
use Nip\Router\RouteCollection;
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

        $router = new Router(null, function () {
            return new RouteCollection();
        });
        $container->set('router', $router);

        $provider->boot();

        $routes = $router->getRoutes();
        self::assertCount(1, $routes);

        self::assertTrue($routes->has('oauth.keys'));

        $request = \Nip\Http\Request::create('/oauth/keys');
        self::assertSame(
            [
                '_route' => 'oauth.keys',
                'controller' => 'ByTIC\Hello\Modules\Oauth\Controllers\KeysController',
                'action' => 'index',
            ],
            $router->matchRequest($request)
        );
    }
}
