<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\RefreshTokens;

use ByTIC\Hello\Models\AbstractBase\Behaviours\HasIdentifier\HasIdentifierRecordsTrait;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * Class Tokens
 * @package ByTIC\Auth\Models\RefreshTokens
 *
 * @method RefreshToken getNew()
 */
class RefreshTokens extends \Nip\Records\RecordManager implements RefreshTokenRepositoryInterface
{
    use HasIdentifierRecordsTrait;

    public const TABLE = 'oauth_refresh_tokens';

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface
     */
    public function getNewRefreshToken()
    {
        return $this->getNew();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $refreshTokenEntity->save();
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $record = $this->findByIdentifierOrFail($tokenId);
        $record->setRevoked(false);
        $record->save();
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $code = $this->findByIdentifierOrFail($tokenId);
        return $code->isRevoked();
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return self::TABLE;
    }
}
