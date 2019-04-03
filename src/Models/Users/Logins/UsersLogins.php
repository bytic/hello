<?php

namespace ByTIC\Hello\Models\Users\Logins;

use ByTIC\Hello\Models\Users\Logins\Traits\LoginsTrait;

/**
 * Class User_Logins
 */
class UsersLogins extends \Nip\Records\RecordManager
{
    use \Nip\Utility\Traits\SingletonTrait;
    use LoginsTrait;
}
