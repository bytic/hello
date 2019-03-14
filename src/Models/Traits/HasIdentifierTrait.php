<?php

namespace ByTIC\Hello\Models\Traits;

/**
 * Trait HasIdentifierTrait
 * @package ByTIC\Hello\Models\Traits
 */
trait HasIdentifierTrait
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Set the token's identifier.
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}