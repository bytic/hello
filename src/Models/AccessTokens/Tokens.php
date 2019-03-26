<?php

namespace ByTIC\Hello\Models\AccessTokens;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Models\Clients\Clients;
use ByTIC\Hello\Models\Users\Traits\UserTrait;
use Carbon\Carbon;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\TokenInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Nip\Records\Collections\Collection;

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
        $token = $this->getByIdentifier($tokenId);
        if ($token instanceof TokenInterface) {
            return $token->revoked;
        }
        return true;
    }

    /**
     * @param UserTrait $user
     * @param Client $client
     * @return Collection|Token[]
     */
    public function getValidUserTokens($user, $client)
    {
        $params = [];
        $params['where'] = [
            ['user_id = ?', $user->getIdentifier()],
            ['client_id = ?', $client->getIdentifier()],
            ['revoked = ?', 0],
            ['expires_at > ?', Carbon::now()->toDateString()],
        ];
        return $this->findByParams($params);
    }

    /**
     * @param $tokenId
     * @return Token|null
     */
    public function getByIdentifier($tokenId)
    {
        $collection = $this->findByField('identifier', $tokenId);
        return $collection->current();
    }

    protected function initRelations()
    {
        parent::initRelations();
        $this->belongsTo('Client', ['class' => Clients::class, 'fk' => 'client_id', 'withPK' => 'identifier']);
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return 'oauth_access_tokens';
    }
}
