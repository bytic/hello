<?php

namespace ByTIC\Hello\Models\Clients;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * Class Tokens
 * @package ByTIC\Hello\Models\Clients
 * @method Client findOneByIdentifier(string $clientIdentifier)
 */
class Clients extends \Nip\Records\RecordManager implements ClientRepositoryInterface
{

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
}
