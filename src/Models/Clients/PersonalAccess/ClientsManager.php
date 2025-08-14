<?php

namespace ByTIC\Hello\Models\Clients\PersonalAccess;

use ByTIC\Hello\Clients\Actions\FindClientByRedirect;
use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Utility\ClientsHelper;
use ByTIC\Hello\Utility\GrantsHelper;
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
        if (static::$client !== null) {
            return static::$client;
        }

        if (ClientsHelper::$personalAccessClientId > 0) {
            $client = ModelsHelper::clients()->findOne(ClientsHelper::$personalAccessClientId);
            if ($client instanceof Client) {
                static::$client = $client;
                return $client;
            }
        }
        $clients = FindClientByRedirect::for(ClientsHelper::PERSONAL_ACCESS_REDIRECT_URI)->fetch();
        if ($clients && $clients->count() == 1) {
            static::$client = $clients->current();
            return $clients->current();
        }

        static::$client = static::create();
        return static::$client;
    }

    public static function resetClient()
    {
        static::$client = null;
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
        $client->addGrants(GrantsHelper::GRANT_TYPE_PERSONAL_ACCESS);
        $client->setRedirectUri(ClientsHelper::PERSONAL_ACCESS_REDIRECT_URI);
        $client->save();
        return $client;
    }
}
