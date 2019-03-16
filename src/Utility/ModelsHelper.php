<?php

namespace ByTIC\Hello\Utility;

use ByTIC\Hello\Models\AccessTokens\Tokens;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Models\Scopes\Scopes;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Class ModelsHelper
 * @package ByTIC\Hello\Utility
 */
class ModelsHelper
{
    protected static $clientsClass = Clients::class;

    protected static $accessTokensClass = Tokens::class;

    protected static $scopesClass = Scopes::class;

    /**
     * @return Clients|\Nip\Records\AbstractModels\RecordManager
     */
    public static function clients()
    {
        return ModelLocator::get(static::$clientsClass);
    }

    /**
     * @param RecordManager $manager
     */
    public static function useClientsManager(RecordManager $manager)
    {
        ModelLocator::set(static::$clientsClass, $manager);
    }

    /**
     * @return Tokens|\Nip\Records\AbstractModels\RecordManager
     */
    public static function accessTokens()
    {
        return ModelLocator::get(static::$accessTokensClass);
    }

    /**
     * @return Scopes|\Nip\Records\AbstractModels\RecordManager
     */
    public static function scopes()
    {
        return ModelLocator::get(static::$scopesClass);
    }
}
