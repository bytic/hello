<?php

namespace ByTIC\Auth\Models\Tokens;

use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\Tokens
 */
class Token extends \Nip\Records\Record
{
    use TokenEntityTrait;
}
