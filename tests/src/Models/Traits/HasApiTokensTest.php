<?php

namespace ByTIC\Hello\Tests\Models\Traits;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\Clients\PersonalAccess\TokenFactory;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Tests\Fixtures\Models\Users\User;
use Mockery as m;
use Nip\Container\Container;
use Nip\Records\Locator\ModelLocator;

/**
 * Class HasApiTokensTest
 * @package ByTIC\Hello\Tests\Models\Traits
 */
class HasApiTokensTest extends AbstractTest
{

    public function testTokenCanBeCreated()
    {
        $container = new Container;
        Container::setInstance($container);

        $factory = m::mock();
        $factory->shouldReceive('make')->once()->with(1, 'name', ['scopes']);
        $container->share(TokenFactory::class, $factory);

        $tokens = m::mock(Tokens::class)->makePartial();
        $tokens->shouldReceive('getByIdentifier')->andReturn(new Token());
        ModelLocator::set(Tokens::class, $tokens);

        $user = new User();
        $user->createToken('name', ['scopes']);
    }

    public function tearDown()
    {
        m::close();
    }
}
