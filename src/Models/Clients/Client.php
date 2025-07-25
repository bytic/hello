<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\Clients;

use ByTIC\Hello\Models\AbstractBase\Behaviours\HasRedirectUri\HasRedirectUriRecordTrait;
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
    use EntityTrait;
    use Traits\ClientHasGrantsTrait;
    use Traits\ClientHasSecretTrait;

    use ClientTrait, HasRedirectUriRecordTrait {
        HasRedirectUriRecordTrait::getRedirectUri insteadof ClientTrait;
    }

    /**
     * Allows filling in Entity parameters during construction.
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->setIdentifier(RandomHelper::generateIdentifier());
        $this->setSecret(RandomHelper::generateToken());
    }

    /**
     * @inheritDoc
     */
    public function writeData($data = false)
    {
        parent::writeData($data);

        if (isset($data['grant_types']) && !empty($data['grant_types'])) {
            $this->initGrantsFromDb($data['grant_types']);
        }

        if (isset($data['identifier']) && !empty($data['identifier'])) {
            $this->initIdentifierFromDb($data['identifier']);
        }
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier)
    {
        $this->setDataValue('identifier', $identifier);
        $this->identifier = $identifier;
    }

    /**
     * @param null $data
     */
    public function initIdentifierFromDb($data = null)
    {
        $data = $data === null ? $this->_data['identifier'] : $data;
        if (!empty($data)) {
            $this->setIdentifier($data);
        }
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        parent::setDataValue('name', $name);
    }
}
