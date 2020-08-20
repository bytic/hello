<?php

namespace ByTIC\Hello\Models\AccessTokens;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AccessTokens
 *
 * @property int $user_id
 * @property int $client_id
 * @property string $revoked
 * @property string $expires_at
 */
class Token extends \Nip\Records\Record implements AccessTokenEntityInterface
{
    use EntityTrait {
        setIdentifier as setIdentifierTrait;
    }
    use TokenEntityTrait {
        getClient as getClientTrait;
        setUserIdentifier as setUserIdentifierTrait;
    }
    use AccessTokenTrait;

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
    public function getClient()
    {
        $client = $this->getClientTrait();
        if ($client instanceof ClientEntityInterface) {
            return $client;
        }
        /** @var ClientEntityInterface $relationClient */
        $relationClient = $this->getRelation('Client')->getResults();
        $this->setClient($relationClient);
        return $relationClient;
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($value)
    {
        $this->setDataValue('identifier', $value);
        $this->setIdentifierTrait($value);
    }

    /**
     * @inheritDoc
     */
    public function setExpiresAt($value)
    {
        $date = new DateTimeImmutable($value);
        $this->setExpiryDateTime($date);
        $this->setDataValue('expires_at', $value);
    }

    /**
     * @param $identifier
     */
    public function setUserId($identifier)
    {
        $this->setUserIdentifier($identifier);
    }


    /**
     * @param int|string|null $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->setUserIdentifierTrait($identifier);
        $this->setDataValue('user_id', $this->getUserIdentifier());
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
        $this->expires_at = ($date) ? $date->format('Y-m-d') : '';
    }
}
