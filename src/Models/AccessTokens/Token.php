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
 * @property string $revoked
 * @property string $expire_at
 */
class Token extends \Nip\Records\Record implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use EntityTrait {
        setIdentifier as setIdentifierTrait;
    }
    use TokenEntityTrait {
        setUserIdentifier as setUserIdentifierTrait;
    }

    public function writeData($data = false)
    {
        parent::writeData($data);
        if (isset($data['expire_at'])) {
            $date = new \DateTime($data['expire_at']);
            $this->setExpiryDateTime($date);
        }
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
     * @inheritDoc
     */
    public function setIdentifier($value)
    {
        $this->_data['identifier'] = $value;
        $this->setIdentifierTrait($value);
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

    /**
     * @inheritDoc
     */
    public function insert()
    {
        $this->castExpireDateTime();
        return parent::insert();
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        $this->castExpireDateTime();
        return parent::insert();
    }

    protected function castExpireDateTime()
    {
        $date = $this->getExpiryDateTime();
        $this->expire_at = ($date) ? $date->format('Y-m-d') : '';
    }
}
