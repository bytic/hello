<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AuthCodes;

use ByTIC\Hello\Models\AbstractBase\Behaviours\HasIdentifier\HasIdentifierRecordsTrait;
use ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthClient\HasOauthClientRecordsTrait;
use ByTIC\Hello\Models\AbstractToken\AbstractTokens;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Nip\Records\RecordManager;

/**
 * Class Tokens
 * @package ByTIC\Auth\Models\Tokens
 *
 * @method AuthCode getNew()
 */
class AuthCodes extends AbstractTokens implements AuthCodeRepositoryInterface
{
    use HasOauthClientRecordsTrait;
    use HasIdentifierRecordsTrait;

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode(): AuthCodeEntityInterface|AuthCode
    {
        return $this->getNew();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface|AuthCode $authCodeEntity
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $authCodeEntity->save();
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        $code = $this->findByIdentifierOrFail($codeId);
        $code->setRevoked(false);
        $code->save();
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId)
    {
        $code = $this->findByIdentifierOrFail($codeId);
        return $code->isRevoked();
    }


    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    protected function generateTable()
    {
        return 'oauth_auth_codes';
    }
}
