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
 *
 * @property int $user_id
 * @property int $client_id
 */
class Token extends \Nip\Records\Record implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait {
        setUserIdentifier as setUserIdentifierTrait;
    }

    /**
     * @param ClientEntityInterface $clientEntity
     */
    public function populateFromClient(ClientEntityInterface $clientEntity)
    {
        $this->setClient($clientEntity);
        $this->client_id = $clientEntity->getIdentifier();
    }

    /**
     * @param int|string|null $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->setUserIdentifierTrait($identifier);
        $this->user_id = $this->getUserIdentifier();
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
