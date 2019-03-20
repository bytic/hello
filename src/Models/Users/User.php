<?php

namespace ByTIC\Hello\Models\Users;

use ByTIC\Hello\Models\Users\Traits\UserTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class User
 * @package ByTIC\Hello\Models\Users
 *
 * @method Users getManager()
 */
class User extends \Nip\Records\Record implements UserEntityInterface
{
    use UserTrait;
}
