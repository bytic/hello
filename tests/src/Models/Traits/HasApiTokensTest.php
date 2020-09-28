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
        $container = Container::getInstance();

        $factory = m::mock();
        $factory->shouldReceive('make')->once()->with('users|1', 'name', ['scopes']);
        $container->share(TokenFactory::class, $factory);

        $tokens = m::mock(Tokens::class)->makePartial();
        $tokens->shouldReceive('getByIdentifier')->andReturn(new Token());
        ModelLocator::set(Tokens::class, $tokens);

        $user = new User();
        $user->setIdentifier('users|1');
        $user->createToken('name', ['scopes']);
    }
}
