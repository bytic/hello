<?php

namespace ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\HelloServiceProvider;
use ByTIC\Hello\Tests\AbstractTest;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Nip\Container\Container;
use Nip\Records\RecordManager;

/**
 * Class RepositoriesTraitTest
 * @package ByTIC\Hello\Tests\Oauth\ServiceProvider\Traits
 */
class RepositoriesTraitTest extends AbstractTest
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
}
