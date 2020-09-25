<?php

namespace ByTIC\Hello\Tests\Utility;

use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Tests\Fixtures\Models\Users\Users;
use ByTIC\Hello\Utility\ConfigHelper;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Nip\Config\Config;
use Nip\Records\Locator\ModelLocator;

/**
 * Class ModelsHelperTest
 * @package ByTIC\Hello\Tests\Utility
 */
class ModelsHelperTest extends AbstractTest
{
    public function test_clients_noConfig()
    {
        $config = new Config();
        ConfigHelper::setConfig($config);

        $entityManager = new Clients();
        ModelLocator::set(Clients::class, $entityManager);

        $clients = ModelsHelper::clients();
        self::assertSame($entityManager, $clients);
    }

    public function test_clients_withConfig()
    {
        $config = new Config(['hello' => ['repositories' => [ClientRepositoryInterface::class => Users::class]]]);
        ConfigHelper::setConfig($config);

        $entityManager = new Users();
        ModelLocator::set(Users::class, $entityManager);

        $clients = ModelsHelper::clients();
        self::assertSame($entityManager, $clients);
    }

    public function test_useClientsManager()
    {
        $config = new Config();
        ConfigHelper::setConfig($config);

        $entityManager = new Clients();
        ModelLocator::set(Clients::class, $entityManager);

        $entityManagerCustom = new Clients();
        $entityManagerCustom->setTable('test');

        ModelsHelper::useClientsManager($entityManagerCustom);
        $clients = ModelsHelper::clients();
        self::assertSame($entityManagerCustom, $clients);
    }

    protected function setUp(): void
    {
        parent::setUp();
        ModelsHelper::reset();
    }
}