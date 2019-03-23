<?php

namespace ByTIC\Hello\Oauth\Routes;

use ByTIC\Hello\Modules\Oauth\Controllers\KeysController;
use Nip\Router\Route\Route;
use Nip\Router\RouteCollection;
use Nip\Router\RouteFactory;
use Nip\Router\Router;

/**
 * Class RouteRegistrar
 * @package ByTIC\Hello\Oauth\Routes
 */
class RouteRegistrar
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * RouteRegistrar constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->routes = $this->router->getRoutes();
    }

    public function all()
    {
        $this->forKeys();
    }

    protected function forKeys()
    {
        RouteFactory::generateLiteralRoute(
            $this->routes,
            "oauth.keys",
            Route::class,
            "",
            "/oauth/keys",
            ["controller" => KeysController::class, "action" => "index"]
        );
    }
}
