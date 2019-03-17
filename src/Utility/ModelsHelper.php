<?php

namespace ByTIC\Hello\Utility;

use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\AuthCodes\AuthCodes;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Models\Scopes\Scopes;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Class ModelsHelper
 * @package ByTIC\Hello\Utility
 */
class ModelsHelper
{
    protected static $repositories = [
        AccessTokenRepositoryInterface::class => Tokens::class,
        ClientRepositoryInterface::class => Clients::class,
        RefreshTokenRepositoryInterface::class => null,
        ScopeRepositoryInterface::class => Scopes::class,
        AuthCodeRepositoryInterface::class => AuthCodes::class,
        UserRepositoryInterface::class => null,
    ];

    /**
     * @return Clients|\Nip\Records\AbstractModels\RecordManager
     */
    public static function clients()
    {
        return static::getRepository(ClientRepositoryInterface::class);
    }

    /**
     * @param RecordManager $manager
     */
    public static function useClientsManager(RecordManager $manager)
    {
        ModelLocator::set(Clients::class, $manager);
    }

    /**
     * @return Tokens|\Nip\Records\AbstractModels\RecordManager
     */
    public static function accessTokens()
    {
        return static::getRepository(AccessTokenRepositoryInterface::class);
    }

    /**
     * @return Scopes|\Nip\Records\AbstractModels\RecordManager
     */
    public static function scopes()
    {
        return static::getRepository(ScopeRepositoryInterface::class);
    }

    /**
     * @param $alias
     * @return \Nip\Records\AbstractModels\RecordManager
     */
    protected static function getRepository($alias)
    {
        $class = static::$repositories[$alias];
        return ModelLocator::get($class);
    }

    /**
     * @return array
     */
    public static function repositories()
    {
        return static::$repositories;
    }
}
