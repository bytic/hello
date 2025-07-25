<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthClient;

use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @property int $client_id
 */
trait HasOauthClientRecordTrait
{
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
    public function getClient(): ClientEntityInterface
    {
        $client = $this->client;
        if ($client instanceof ClientEntityInterface) {
            return $client;
        }
        /** @var ClientEntityInterface $relationClient */
        $relationClient = $this->getRelation('ClientRecord')->getResults();
        $this->setClient($relationClient);
        return $relationClient;
    }

    public function setClientId(string $clientId): void
    {
        $this->client_id = $clientId;
        $client = $this->getClientRecord();
        if ($client) {
            $this->setClient($client);
        }
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client_id = $client->id;
        $this->client = $client;
    }
}

