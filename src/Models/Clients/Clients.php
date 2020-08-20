<?php

namespace ByTIC\Hello\Models\Clients;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Nip\Records\Collections\Collection;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Tokens
 * @package ByTIC\Hello\Models\Clients
 *
 * @method Client getNew()
 * @method Client findOneByIdentifier(string $clientIdentifier)
 * @method Client findOne(string $clientIdentifier)
 *
 * @method Client[]|Collection findByRedirect(string $uri)
 */
class Clients extends \Nip\Records\RecordManager implements ClientRepositoryInterface
{
    use SingletonTrait;

    /**
     * {@inheritdoc}
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType = null,
        $clientSecret = null,
        $mustValidateSecret = true
    ) {
        // First, we will verify that the client exists
        $client = $this->findOneByIdentifier($clientIdentifier);

        if (!$client || !$client->handlesGrant($grantType)) {
            return;
        }

        if ($mustValidateSecret && !$client->validateSecret($clientSecret)) {
            return;
        }
        return $client;
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return 'oauth_clients';
    }

    /**
     * @inheritDoc
     * @TODO add some validation logic
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        return true;
    }
}
