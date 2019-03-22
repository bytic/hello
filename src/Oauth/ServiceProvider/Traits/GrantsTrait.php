<?php

namespace ByTIC\Hello\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\Utility\ConfigHelper;
use DateInterval;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * Trait GrantsTrait
 * @package ByTIC\Hello\Oauth\ServiceProvider\Traits
 */
trait GrantsTrait
{
    /**
     * @param AuthorizationServer $server
     */
    public function registerGrants(AuthorizationServer $server)
    {
        $grantTypes = $this->getRegisteredGrants();
        foreach ($grantTypes as $type => $class) {
            $method = 'makeGrant' . $type;
            $this->{$method}($server, $class);
        }
    }

    /**
     * @return mixed|\Nip\Config\Config
     */
    protected function getRegisteredGrants()
    {
        return ConfigHelper::get('grant_types', []);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantPersonalAccess(AuthorizationServer $server, string $class)
    {
        $this->makeGrant(
            $server,
            $class,
            [],
            new DateInterval('P1Y')
        );
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantAuthCode(AuthorizationServer $server, string $class)
    {
        $this->makeGrant(
            $server,
            $class,
            [
                $this->getContainer()->get(AuthCodeRepositoryInterface::class),
                $this->getContainer()->get(RefreshTokenRepositoryInterface::class),
                ConfigHelper::get('token_ttl')
            ]
        );
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantRefreshToken(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            $this->getContainer()->get(RefreshTokenRepositoryInterface::class)
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantPassword(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            $this->getContainer()->get(UserRepositoryInterface::class),
            $this->getContainer()->get(RefreshTokenRepositoryInterface::class)
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantImplicit(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, [
            ConfigHelper::get('token_ttl')
        ]);
    }

    /**
     * @param AuthorizationServer $server
     * @param string $class
     */
    protected function makeGrantClientCredentials(AuthorizationServer $server, string $class)
    {
        $this->makeGrant($server, $class, []);
    }

    /**
     * @param AuthorizationServer $server
     * @param string|null $type
     * @param array $args
     */
    protected function makeGrant(AuthorizationServer $server, string $type, array $args, $accessTokenTTL = null)
    {
        if ($type !== null) {
            $grant = new $type(...$args);
            if ($type !== null && $grant !== null) {
                $server->enableGrantType($grant, $accessTokenTTL);
            }
        }
    }
}
