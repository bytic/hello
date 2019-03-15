<?php

namespace ByTIC\Hello\Models\Clients;

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
    use Traits\ClientHasRedirectTrait;

    public function __construct()
    {
        $this->setIdentifier(RandomHelper::generateIdentifier());
        $this->setSecret(RandomHelper::generateToken());
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        parent::setName($name);
    }
}
