<?php

namespace ByTIC\Hello\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\Utility\CryptHelper;

/**
 * Trait CryptKeysTrait
 * @package ByTIC\Hello\Oauth\ServiceProvider\Traits
 */
trait CryptKeysTrait
{
    public function registerCryptKeys()
    {
        $this->getContainer()->share('hello.keys.private', function () {
            return $this->makeCryptKey('private');
        });
        $this->getContainer()->share('hello.keys.public', function () {
            return $this->makeCryptKey('public');
        });
    }

    /**
     * @param $return
     * @return array
     */
    protected function appendCryptKeysToProvide($return)
    {
        $return[] = 'hello.keys.private';
        $return[] = 'hello.keys.public';
        return $return;
    }

    /**
     * Create a CryptKey instance without permissions check
     *
     * @param  $type
     * @return \League\OAuth2\Server\CryptKey
     */
    protected function makeCryptKey($type)
    {
        return CryptHelper::makeCryptKey($type);
    }
}
