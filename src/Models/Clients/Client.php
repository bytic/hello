<?php

namespace ByTIC\Hello\Models\Clients;

use ByTIC\Hello\Models\Traits\HasIdentifierTrait;
use ByTIC\Hello\Utility\GrantsHelper;
use ByTIC\Hello\Utility\RandomHelper;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Class Token
 * @package ByTIC\Hello\Models\Clients
 */
class Client extends \Nip\Records\Record implements ClientEntityInterface
{
    use ClientTrait, EntityTrait;
    use Traits\ClientHasGrantsTrait;
    use Traits\ClientHasSecretTrait;
    use HasIdentifierTrait;

    public function __construct()
    {
//        $this->setRandomId(RandomHelper::generateToken());
//        $this->setSecret(RandomHelper::generateToken());
    }

    /**
     * {@inheritdoc}
     */
    public function setAllowedGrantTypes(array $grantTypes)
    {
        $this->allowedGrantTypes = $grantTypes;
    }
    /**
     * {@inheritdoc}
     */
    public function getAllowedGrantTypes()
    {
        return $this->allowedGrantTypes;
    }
}
