<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AuthCodes;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Hello\Models\AbstractBase\Behaviours\HasRedirectUri\HasRedirectUriRecordTrait;
use ByTIC\Hello\Models\AbstractBase\Behaviours\HasRevoked\HasRevokedRecordTrait;
use ByTIC\Hello\Models\AbstractToken\AbstractToken;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AuthCodes
 */
class AuthCode extends AbstractToken implements AuthCodeEntityInterface
{
    use AuthCodeTrait, HasRedirectUriRecordTrait {
        HasRedirectUriRecordTrait::getRedirectUri insteadof AuthCodeTrait;
        HasRedirectUriRecordTrait::setRedirectUri insteadof AuthCodeTrait;
    }
    use EntityTrait;
    use HasRevokedRecordTrait;
    use TimestampableTrait;

    /**
     * @var string
     */
    static protected $createTimestamps = ['created_at'];

    /**
     * @var string
     */
    static protected $updateTimestamps = [];

    /**
     * Get the attributes that have been changed since last sync.
     *
     * @param null $fields
     */
    public function getDirty($fields = null): array
    {
        $return = parent::getDirty($fields);
        $return['scopes'] = implode(' ', array_map(function ($scope) {
            return $scope->getIdentifier();
        }, $this->getScopes()));
        return $return;
    }

}
