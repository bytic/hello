<?php

namespace ByTIC\Hello\Models\Clients\Traits;

/**
 * Trait ClientHasSecretTrait
 * @package ByTIC\Hello\Models\Clients\Traits
 *
 * @property string $secret
 */
trait ClientHasSecretTrait
{
    /**
     * @param string $secret
     * @return bool
     */
    public function validateSecret(string $secret): bool
    {
        return $this->secret === $secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
