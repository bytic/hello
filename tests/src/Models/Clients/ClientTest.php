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
