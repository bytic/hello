<?php

namespace ByTIC\Hello\Tests\Models\Traits;

use ByTIC\Hello\Tests\Fixtures\Models\Users\User;
use Mockery as m;
use ByTIC\Hello\Tests\AbstractTest;
use Nip\Container\Container;

/**
 * Class HasApiTokensTest
 * @package ByTIC\Hello\Tests\Models\Traits
 */
class HasApiTokensTest extends AbstractTest
{

    public function tearDown()
    {
        m::close();
    }

    public function testTokenCanBeCreated()
    {
//        $container = new Container;
//        Container::setInstance($container);
//
//        $container->share(PersonalAccessTokenFactory::class, $factory = m::mock());
//        $factory->shouldReceive('make')->once()->with(1, 'name', ['scopes']);
//
//        $user = new User();
//        $user->createToken('name', ['scopes']);
    }
}
