<?php

namespace ByTIC\Hello\Models\Users\Traits;

use ByTIC\Auth\Models\Users\Traits\AbstractUserTrait;
use ByTIC\Hello\Models\Clients\PersonalAccess\ClientsManager;
use ByTIC\Hello\Models\Traits\HasApiTokensTrait;
use ByTIC\Hello\Models\Users\Resolvers\UsersResolvers;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Trait UserTrait
 * @package ByTIC\Hello\Models\Users\
 *
 * @property string $access_token
*/
trait UserTrait
{
    use AbstractUserTrait {
        doAuthentication as doAuthenticationTrait;
    }
    use HasApiTokensTrait, EntityTrait;

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

    public function doAuthentication()
    {
        $this->doAuthenticationTrait();
        $this->access_token = $this->token()->getIdentifier();
    }

    protected function initIdentifier()
    {
        $this->setIdentifier(UsersResolvers::identifier($this));
    }

    /**
     * @return \ByTIC\Hello\Models\AccessTokens\Token|null
     */
    protected function generateToken()
    {
        $userTokens = ModelsHelper::accessTokens()->getValidUserTokens($this, ClientsManager::get());
        if (count($userTokens) < 1) {
            return $this->createToken($this->generateTokenName());
        }
        return $userTokens->current();
    }
}