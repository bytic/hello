<?php

namespace ByTIC\Hello\Models\Users;

use ByTIC\Hello\Models\Users\Traits\UsersTrait;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Users
 * @package ByTIC\Hello\Models\Users
 *
 * @method User getNew()
 */
class Users extends \Nip\Records\RecordManager implements UserRepositoryInterface
{
    use SingletonTrait;
    use UsersTrait;

    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        // TODO: Implement getUserEntityByUserCredentials() method.
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return 'users';
    }
}
