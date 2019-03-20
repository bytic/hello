<?php

namespace ByTIC\Hello\Models\Users\Traits;

use ByTIC\Auth\Models\Users\Traits\AbstractUserTrait;
use ByTIC\Hello\Models\Users\Resolvers\UsersResolvers;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Trait UserTrait
 * @package ByTIC\Hello\Models\Users\Traits
 */
trait UserTrait
{
    use AbstractUserTrait, EntityTrait;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        if (empty($this->identifier)) {
            $this->initIdentifier();
        }
        return $this->identifier;
    }

    protected function initIdentifier()
    {
        $this->setIdentifier(UsersResolvers::identifier($this));
    }
}
