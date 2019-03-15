<?php

namespace ByTIC\Hello\Tests\Models\Clients\Traits;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\GrantsHelper;

/**
 * Class ClientHasGrantsTraitTest
 * @package ByTIC\Hello\Tests\Models\Clients\Traits
 */
class ClientHasGrantsTraitTest extends AbstractTest
{
    public function testNewClientGrants()
    {
        $client = new Client();
        self::assertSame([], $client->getGrants());
    }

    public function testAddGrants()
    {
        $client = new Client();

        $client->addGrants(GrantsHelper::GRANT_TYPE_EXTENSIONS);
        self::assertSame([GrantsHelper::GRANT_TYPE_EXTENSIONS], $client->getGrants());

        $client->addGrants(GrantsHelper::GRANT_TYPE_EXTENSIONS);
        self::assertSame([GrantsHelper::GRANT_TYPE_EXTENSIONS], $client->getGrants());

        $client->addGrants(GrantsHelper::GRANT_TYPE_AUTH_CODE);
        self::assertSame(
            [GrantsHelper::GRANT_TYPE_EXTENSIONS, GrantsHelper::GRANT_TYPE_AUTH_CODE],
            $client->getGrants()
        );
    }

    public function testHasGrant()
    {
        $client = new Client();
        self::assertFalse($client->hasGrant(GrantsHelper::GRANT_TYPE_AUTH_CODE));

        $client->addGrants(GrantsHelper::GRANT_TYPE_EXTENSIONS);
        self::assertFalse($client->hasGrant(GrantsHelper::GRANT_TYPE_AUTH_CODE));

        $client->addGrants(GrantsHelper::GRANT_TYPE_AUTH_CODE);
        self::assertTrue($client->hasGrant(GrantsHelper::GRANT_TYPE_AUTH_CODE));
    }
}