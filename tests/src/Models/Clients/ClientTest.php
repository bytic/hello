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
    /**
     * @dataProvider dataInitFromDB()
     * @param $grantDb
     * @param $grantArray
     */
    public function testInitFromDB($grantDb, $grantArray)
    {
        $client = new Client();
        $client->writeData(['id' => 9, 'grant_types' => $grantDb]);

        self::assertSame($grantArray, $client->getGrants());
    }

    /**
     * @return array
     */
    public static function dataInitFromDB()
    {
        return [
            ['', []],
            ['personal_access', ['personal_access']],
            ['personal_access,authorization_code', ['personal_access', 'authorization_code']],
        ];
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
