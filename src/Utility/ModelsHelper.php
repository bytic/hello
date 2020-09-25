<?php

namespace ByTIC\Hello\Utility;

use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\AuthCodes\AuthCodes;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Models\RefreshTokens\RefreshTokens;
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

    protected static $resolved = [];

    protected static $repositories = [
        AccessTokenRepositoryInterface::class => Tokens::class,
        ClientRepositoryInterface::class => Clients::class,
        RefreshTokenRepositoryInterface::class => RefreshTokens::class,
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
        static::setRepository(ClientRepositoryInterface::class, $manager);
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
     * @return array
     */
    public static function repositories()
    {
        return static::$repositories;
    }

    /**
     * @return array
     */
    public static function reset()
    {
        return static::$resolved =[];
    }

    /**
     * @param $alias
     * @return \Nip\Records\AbstractModels\RecordManager
     */
    protected static function getRepository($alias)
    {
        if (!isset(static::$resolved[$alias])) {
            static::$resolved[$alias] = static::generateRepository($alias);
        }
        return static::$resolved[$alias];
    }

    /**
     * @param $interface
     * @return \Nip\Records\AbstractModels\RecordManager
     */
    protected static function generateRepository($interface)
    {
        $class = ConfigHelper::get('repositories.'.$interface, false);
        if (!empty($class) && class_exists($class)) {
            return ModelLocator::get($class);
        }
        return ModelLocator::get(static::$repositories[$interface]);
    }

    /**
     * @param $interface
     * @param RecordManager $manager
     */
    protected static function setRepository($interface, $manager)
    {
        static::$resolved[$interface] = $manager;
        ModelLocator::set($interface, $manager);
    }
}
