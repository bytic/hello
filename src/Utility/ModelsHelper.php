<?php

namespace ByTIC\Hello\Utility;

use ByTIC\Hello\Models\Clients\Clients;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Class ModelsHelper
 * @package ByTIC\Hello\Utility
 */
class ModelsHelper
{
    protected static $clientsClass = Clients::class;

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
}
