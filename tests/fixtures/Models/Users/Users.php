<?php

namespace ByTIC\Hello\Tests\Fixtures\Models\Users;

use ByTIC\Hello\Models\Users\Traits\UsersTrait;
use Nip\Records\RecordManager;

/**
 * Class Users
 * @package ByTIC\Hello\Tests\Fixtures\Models\Users
 */
class Users extends RecordManager
{
    use UsersTrait;

    /**
     * @return string
     */
    public function generateTable()
    {
        return 'users';
    }
}
