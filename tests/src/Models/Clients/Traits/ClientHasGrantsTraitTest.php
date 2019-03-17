<?php

namespace ByTIC\Hello\Tests\Models\Clients\Traits;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
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

    public function testGrantsSave()
    {
        /** @var Clients $clients */
        $clients = \Mockery::mock(Clients::class)->makePartial();
        $clients->shouldReceive('getFields')->andReturn(['id', 'identifier', 'grant_types']);
        $clients->shouldReceive('getPrimaryKey')->andReturn('id');
        $clients->shouldReceive('getModel')->andReturn(Client::class);

        $client = $clients->getNew();
        $client->addGrants([GrantsHelper::GRANT_TYPE_PERSONAL_ACCESS, GrantsHelper::GRANT_TYPE_AUTH_CODE]);

        $data = $clients->getQueryModelData($client);
        self::assertArrayHasKey('grant_types', $data);
    }
}
