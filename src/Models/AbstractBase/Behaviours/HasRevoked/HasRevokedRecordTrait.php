<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasRevoked;

/**
 * @property $revoked
 */
trait HasRevokedRecordTrait
{

    public function setRevoked(bool $true): static
    {
        $this->setPropertyValue('revoked', $true ? 1 : 0);
        return $this;
    }

    public function isRevoked(): bool
    {
        return (bool)$this->getPropertyValue('revoked');
    }
}