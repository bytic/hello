<?php

namespace ByTIC\Hello\Models\AccessTokens;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AccessTokens
 */
class Token extends \Nip\Records\Record implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait;

    /**
     * @param ClientEntityInterface $clientEntity
     */
    public function populateFromClient(ClientEntityInterface $clientEntity)
    {
        $this->setClient($clientEntity);
    }
    /**
     * @param $scopes
*/
    public function addScopes($scopes)
    {
        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }
    }
}
