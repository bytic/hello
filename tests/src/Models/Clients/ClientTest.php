<?php

namespace ByTIC\Hello\Tests\Models\Clients;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Tests\AbstractTest;

/**
 * Class ClientTest
 * @package ByTIC\Hello\Tests\Models\Clients
 */
class ClientTest extends AbstractTest
{
    public function testInitIdentifierFromDB()
    {
        $client = new Client();
        self::assertGreaterThan('10', strlen($client->getIdentifier()));

        $client->writeData(['id' => 9, 'identifier' => '']);
        self::assertEmpty($client->getIdentifier());

        $client->writeData(['id' => 9, 'identifier' => '9999']);
        self::assertSame('9999', $client->getIdentifier());
    }

    public function testSetIdentifier()
    {
        /** @var Clients $clients */
        $clients = \Mockery::mock(Clients::class)->makePartial();
        $clients->shouldReceive('getFields')->andReturn(['id', 'identifier', 'secret']);
        $clients->shouldReceive('getPrimaryKey')->andReturn('id');
        $clients->shouldReceive('getModel')->andReturn(Client::class);

        $client = $clients->getNew();
        $identifier = $client->getIdentifier();
        self::assertGreaterThan(30, strlen($identifier));

        $data = $clients->getQueryModelData($client);
        self::assertArrayHasKey('identifier', $data);
    }
}
