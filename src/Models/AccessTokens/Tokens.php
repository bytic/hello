<?php

namespace ByTIC\Hello\Models\AccessTokens;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * Class Tokens
 * @package ByTIC\Auth\Models\Tokens
 *
 * @method Token getNew()
 */
class Tokens extends \Nip\Records\RecordManager implements AccessTokenRepositoryInterface
{
    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface|Token
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $token = $this->getNew();
        $token->populateFromClient($clientEntity);
        $token->setUserIdentifier($userIdentifier);
        $token->addScopes($scopes);
        return $token;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface|Token $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenEntity->save();
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $token = $this->getByIdentifier($tokenId);
        if (!($token instanceof Token)) {
            return;
        }
        $token->revoked = true;
        $token->save();
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        if ($token = $this->getByIdentifier($tokenId)) {
            return $token->revoked;
        }
        return true;
    }

    /**
     * @param $tokenId
     * @return Token|null
     */
    public function getByIdentifier($tokenId)
    {
        return $this->findByField('identifier', $tokenId);
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return 'oauth_access_tokens';
    }
}
