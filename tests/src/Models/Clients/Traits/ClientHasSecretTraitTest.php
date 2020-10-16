<?php

namespace ByTIC\Hello\Tests\Models\Clients\Traits;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\GrantsHelper;

/**
 * Class ClientHasSecretTraitTest
 * @package ByTIC\Hello\Tests\Models\Clients\Traits
 */
class ClientHasSecretTraitTest extends AbstractTest
{
    public function test_new_client_has_secret()
    {
        $client = new Client();
        self::assertGreaterThan('10', strlen($client->getSecret()));
    }
}
