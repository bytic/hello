<?php

namespace ByTIC\Hello\Models\Scopes;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AccessTokens
 */
class Scope extends \Nip\Records\Record implements ScopeEntityInterface
{
    use ScopeTrait;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }
}
