<?php

namespace ByTIC\Hello\Tests\Models\Users\Resolvers;

use ByTIC\Hello\Models\Users\User;
use ByTIC\Hello\Models\Users\Users;
use ByTIC\Hello\Tests\AbstractTest;

/**
 * Class UsersResolversTest
 * @package ByTIC\Hello\Tests\Models\Users\Resolvers
 */
class UsersResolversTest extends AbstractTest
{
    public function testIdentifier()
    {
        $manager = Users::instance();
        $manager->setPrimaryKey('id');

        $user = new User();
        $user->setManager($manager);
        $user->id = 9;

        self::assertSame('users|9', $user->getIdentifier());
    }
}
