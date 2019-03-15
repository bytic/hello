<?php

namespace ByTIC\Hello\Tests\Models\Clients\PersonalAccess;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Models\Clients\PersonalAccess\ClientsManager;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\ModelsHelper;

/**
 * Class ClientsManagerTest
 * @package ByTIC\Hello\Tests\Models\Clients\PersonalAccess
 */
class ClientsManagerTest extends AbstractTest
{

    /**
     * @param null|string $name
     * @dataProvider createDataProvider
     */
    public function testCreate($nameIn, $nameOut)
    {
        $clientsManager = \Mockery::mock(Clients::class)->makePartial();
        $clientsManager->shouldReceive('getPrimaryKey')->andReturn('id');
        $clientsManager->shouldReceive('getModel')->andReturn(Client::class);
        $clientsManager->shouldReceive('save');

        ModelsHelper::useClientsManager($clientsManager);
        $client = ClientsManager::create($nameIn);

        self::assertInstanceOf(Client::class, $client);
        self::assertSame($nameOut, $client->getName());
        self::assertSame(32, strlen($client->getIdentifier()));
        self::assertGreaterThan(40, strlen($client->getSecret()));
        self::assertSame('INTERNAL_API', $client->getRedirectUri());
    }

    /**
     * @return array
     */
    public function createDataProvider()
    {
        return [
            [null,'Personal Access Client'],
            ['','Personal Access Client'],
            ['test1','test1'],
        ];
    }
}
