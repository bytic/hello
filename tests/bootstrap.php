<?php

use Mockery\Mock;
use Nip\Cache\Stores\Repository;
use Nip\Container\Container;
use Nip\Database\Connections\Connection;
use Nip\Database\DatabaseManager;
use Nip\Database\Metadata\Manager;
use Nip\Inflector\Inflector;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require dirname(__DIR__) . '/vendor/autoload.php';

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'src');
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

$container =new Container();
Container::setInstance($container);

$container->set('inflector', new Inflector());

$adapter = Mockery::mock(\Nip\Database\Adapters\MySQLi::class)->makePartial();
$adapter->shouldReceive('cleanData')->andReturnUsing(
    function ($fn) {
        return $fn;
    }
);

/** @var Mock|Connection $connection */
$connection = Mockery::mock(Connection::class)->makePartial();
$connection->setAdapter($adapter);
$connection->setDatabase('42km_ro_register');

$metadata = Mockery::mock(Manager::class)->makePartial();
$metadata->shouldReceive('describeTable')->andReturn(['fields' => []]);
$connection->shouldReceive('getMetadata')->andReturn($metadata);

$manager = new DatabaseManager();
$manager->setConnection($connection, 'main');

$container->set('db', $manager);
$container->set('db.connection', $connection);

$adapter = new FilesystemAdapter('', 600, TEST_FIXTURE_PATH.'/storage/cache');
$store = new Repository($adapter);
$store->clear();
$container->set('cache.store', $store);
