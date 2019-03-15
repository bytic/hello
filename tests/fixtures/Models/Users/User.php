<?php

namespace ByTIC\Hello\Tests\Fixtures\Models\Users;

use ByTIC\Hello\Models\Traits\HasApiTokensTrait;
use Nip\Records\Record;

/**
 * Class User
 * @package ByTIC\Hello\Tests\Fixtures\Models\Users
 */
class User extends Record
{
    use HasApiTokensTrait;

    /**
     * @inheritdoc
     */
    public function getPrimaryKey()
    {
        return 1;
    }
}
