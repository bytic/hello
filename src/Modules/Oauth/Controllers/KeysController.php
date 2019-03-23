<?php

namespace ByTIC\Hello\Modules\Oauth\Controllers;

use League\OAuth2\Server\CryptKey;
use Nip\Container\Container;
use Nip\Controllers\Controller;
use Nip\Http\Response\JsonResponse;

/**
 * Class KeysController
 * @package ByTIC\Hello\Modules\Oauth\Controllers
 */
class KeysController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $container = function_exists('app') ? app() : Container::getInstance();
        /** @var CryptKey $publicKey */
        $publicKey = $container->get('hello.keys.public');

        $key = new \stdClass();
        $key->alg = "RS256";
        $key->kty = "RSA";
        $key->use = "sig";
        $key->x5c = [file_get_contents($publicKey->getKeyPath())];
        $data = ['keys' => [$key]];

        return new JsonResponse($data);
    }
}
