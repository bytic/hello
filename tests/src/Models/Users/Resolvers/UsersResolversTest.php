<?php

namespace ByTIC\Hello\Tests\Models\Users\Resolvers;

use ByTIC\Hello\Models\Users\User;
use ByTIC\Hello\Tests\AbstractTest;

/**
 * Class UsersResolversTest
 * @package ByTIC\Hello\Tests\Models\Users\Resolvers
 */
class UsersResolversTest extends AbstractTest
{

    public function testIdentifier()
    {
        $user = new User();
        $user->getManager()->setPrimaryKey('id');
        $user->id = 9;

        self::assertSame('users|9', $user->getIdentifier());
    }
}
