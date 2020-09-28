<?php

namespace ByTIC\Hello\Models\Users\Resolvers;

use ByTIC\Hello\Models\Users\Traits\UserTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\Record;

/**
 * Class UsersResolvers
 * @package ByTIC\Hello\Models\Users\Resolvers
 */
class UsersResolvers
{
    public const SEPARATOR = '|';

    /**
     * @param Record|UserEntityInterface|UserTrait $entity
     * @return string
     */
    public static function identifier(Record $entity)
    {
        return $entity->getManager()->getTable() . static::SEPARATOR . $entity->getPrimaryKey();
    }

    /**
     * @param string $identifier
     * @return string
     */
    public static function resolve(string $identifier)
    {
        list($userTable, $userIdentifier) = static::parseIdentifier($identifier);
        return static::resolveEntity($userTable, $userIdentifier);
    }


    /**
     * @param $userTable
     * @param $userIdentifier
     * @return \Nip\Records\AbstractModels\Record
     */
    protected static function resolveEntity($userTable, $userIdentifier)
    {
        $userRepository = ModelLocator::get($userTable);
        return $userRepository->findOne($userIdentifier);
    }

    /**
     * @param string $identifier
     * @return array
     */
    protected static function parseIdentifier($identifier)
    {
        if (strpos($identifier, static::class)) {
            $identifier = static::class . $identifier;
        }
        list($userTable, $userIdentifier) = explode(static::SEPARATOR, $identifier);
        $userTable = empty($userTable) ? 'users' : $userTable;
        return [$userTable, $userIdentifier];
    }
}
