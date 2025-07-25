<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AccessTokens;

use ByTIC\Hello\Models\AbstractToken\AbstractToken;
use ByTIC\Hello\Utility\ModelsHelper;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AccessTokens
 *
 * @property string $revoked
 */
class Token extends AbstractToken implements AccessTokenEntityInterface
{
    use EntityTrait {
        setIdentifier as setIdentifierTrait;
    }
    use AccessTokenTrait;

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier)
    {
        $this->setPropertyValue('identifier', $identifier);
        $this->setIdentifierTrait($identifier);
    }


    /**
     * @param $scopes
     */
    public function setScopes($scopes)
    {
        if (is_string($scopes)) {
            $this->addScopesFromString($scopes);
            return;
        }
        $this->scopes = $scopes;
    }

    /**
     * @param $scopes
     */
    public function addScopesFromString($scopes)
    {
        $scopes = array_filter(explode(',', $scopes));
        foreach ($scopes as $key => $scope) {
            $scopes[$key] = ModelsHelper::scopes()->getScopeEntityByIdentifier($scope);
        }
        $this->addScopes($scopes);
    }

    /**
     * @param $scopes
     */
    public function addScopes($scopes)
    {
        foreach ($scopes as $scope) {
            $this->addScope($scope);
        }
    }
}
