<?php

namespace ByTIC\Hello;

use ByTIC\Hello\Oauth\Routes\RouteRegistrar;
use ByTIC\Hello\Oauth\ServiceProvider\Traits\AuthorizationServerTrait;
use ByTIC\Hello\Oauth\ServiceProvider\Traits\RepositoriesTrait;
use League\OAuth2\Server\AuthorizationServer;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class HelloServiceProvider
 * @package ByTIC\Auth
 */
class HelloServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    use RepositoriesTrait;
    use AuthorizationServerTrait;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerRepositories();
        $this->registerAuthorizationServer();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        $return = ['hello.server', AuthorizationServer::class];

        $return = $this->appendRepositoriesToProvide($return);
        $return = $this->appendCryptKeysToProvide($return);
        return $return;
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        $router = $this->getContainer()->get('router');
        (new RouteRegistrar($router))->all();

        $this->registerResources();
    }

    protected function registerResources()
    {
        $folder = dirname(__DIR__) . '/resources/lang/';
        $languages = $this->getContainer()->get('translation.languages');

        $translator = $this->getContainer()->get('translator');

        foreach ($languages as $language) {
            $path = $folder . $language;
            if (is_dir($path)) {
                $translator->addResource('php', $path, $language);
            }
        }
    }
}
