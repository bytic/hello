<?php

namespace ByTIC\Hello\Models\Clients\PersonalAccess;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Utility\ClientsHelper;
use ByTIC\Hello\Utility\ModelsHelper;

/**
 * Class ClientsManager
 * @package ByTIC\Hello\Models\Clients\PersonalAccess
 */
class ClientsManager
{
    protected static $client = null;

    /**
     * @return \ByTIC\Hello\Models\Clients\Client
     */
    public static function get()
    {
        if (static::$client != null) {
            return static::$client;
        }

        if (ClientsHelper::$personalAccessClientId) {
            return ModelsHelper::clients()->findOne(ClientsHelper::$personalAccessClientId);
        }
        $clients = ModelsHelper::clients()->findByRedirect(ClientsHelper::PERSONAL_ACCESS_REDIRECT_URI);
        if (count($clients) === 1) {
            return $clients->current();
        }

        return static::create();
    }

    /**
     * @param string $name
     * @return Client
     */
    public static function create($name = null)
    {
        $client = ModelsHelper::clients()->getNew();

        $name = empty($name) ? 'Personal Access Client' : $name;
        $client->setName($name);

        $client->setRedirectUri(ClientsHelper::PERSONAL_ACCESS_REDIRECT_URI);
        $client->save();
        return $client;
    }
}