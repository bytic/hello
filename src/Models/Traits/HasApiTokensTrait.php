<?php

namespace ByTIC\Hello\Models\Traits;

use ByTIC\Hello\Models\AccessTokens\Token;
use ByTIC\Hello\Models\Clients\PersonalAccess\TokenFactory;
use ByTIC\Hello\Utility\ModelsHelper;
use Nip\Container\Container;

/**
 * Trait HasApiTokensTrait
 * @package ByTIC\Hello\Models\Traits
 */
trait HasApiTokensTrait
{
    /**
     * The current access token for the authentication user.
     *
     * @var Token
     */
    protected $accessToken = null;

    /**
     * Set the current access token being used by the user.
     *
     * @param Token|boolean $token
     * @return Token|null
     */
    public function setToken($token)
    {
        return $this->accessToken = $token;
    }

    /**
     * Get the current access token being used by the user.
     *
     * @return Token|null
     */
    public function token()
    {
        if ($this->accessToken === null) {
            $this->initToken();
        }
        return $this->accessToken;
    }

    /**
     * @param $name
     * @param array $scopes
     */
    public function initTokenInModel($name, array $scopes = [])
    {
        $token = $this->createToken($name, $scopes);
        $this->setToken($token);
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array $scopes
     * @return Token|null
     */
    public function createToken($name, array $scopes = [])
    {
        $tokenResponse = Container::getInstance()
            ->get(TokenFactory::class)
            ->make($this->getPrimaryKey(), $name, $scopes);

        return ModelsHelper::accessTokens()->getByIdentifier($tokenResponse['access_token']);
    }

    protected function initToken()
    {
        $this->setToken($this->generateToken());
    }

    /**
     * @return bool
     */
    protected function generateToken()
    {
        return false;
    }

    /**
     * @param null $name
     * @return string|null
     */
    protected function generateTokenName($name = null)
    {
        return !empty($name) ? $name : 'default';
    }
}
