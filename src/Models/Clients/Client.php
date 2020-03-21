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
    public function setIdentifier($value)
    {
        $this->_data['identifier'] = $value;
        $this->identifier = $value;
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
