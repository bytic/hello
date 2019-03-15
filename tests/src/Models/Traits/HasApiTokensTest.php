<?php

namespace ByTIC\Hello\Tests\Models\Traits;

use ByTIC\Hello\Models\Clients\PersonalAccess\TokenFactory;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Tests\Fixtures\Models\Users\User;
use Mockery as m;
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
        $container = new Container;
        Container::setInstance($container);

        $factory = m::mock();
        $factory->shouldReceive('make')->once()->with(1, 'name', ['scopes']);
        $container->share(TokenFactory::class, $factory);

        $user = new User();
        $user->createToken('name', ['scopes']);
    }
}
