<?php

namespace ByTIC\Hello\Tests\Modules\Oauth\Controllers;

use ByTIC\Hello\Modules\Oauth\Controllers\KeysController;
use ByTIC\Hello\Tests\AbstractTest;
use ByTIC\Hello\Utility\CryptHelper;
use Nip\Container\Container;
use Nip\Http\Response\JsonResponse;

/**
 * Class KeysControllerTest
 * @package ByTIC\Hello\Tests\Modules\Oauth\Controllers
 */
class KeysControllerTest extends AbstractTest
{
    public function testIndex()
    {
        $container = Container::getInstance();
        $container->set('hello.keys.public', CryptHelper::makeCryptKey('public'));

        $controller = new KeysController();
        /** @var JsonResponse $response */
        $response = $controller->callAction('index');

        self::assertInstanceOf(JsonResponse::class, $response);
        $content = $response->getContent();
        self::assertJson($content);
    }
}
