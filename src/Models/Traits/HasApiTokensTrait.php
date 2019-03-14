<?php

namespace ByTIC\Hello\Models\Traits;

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
     * @var \Laravel\Passport\Token
     */
    protected $accessToken;

    /**
     * Get the current access token being used by the user.
     *
     * @return \Laravel\Passport\Token|null
     */
    public function token()
    {
        return $this->accessToken;
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array $scopes
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function createToken($name, array $scopes = [])
    {
        return Container::getInstance()
            ->make(PersonalAccessTokenFactory::class)
            ->make($this->getKey(), $name, $scopes);
    }
}
