<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasExpireDate;

use DateTimeImmutable;

/**
 * @property string $expires_at
 */
trait HasExpireDateRecordTrait
{
    /**
     * @inheritDoc
     */
    public function setExpiresAt($value)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $date = new DateTimeImmutable($value);
        $this->setExpiryDateTime($date);
        $this->setDataValue('expires_at', $value);
    }
    /**
     * @inheritDoc
     */
    public function insert()
    {
        $this->castExpireDateTime();
        return parent::insert();
    }

    /**
     * @inheritDoc
     */
    public function update()
    {
        $this->castExpireDateTime();
        return parent::insert();
    }

    protected function castExpireDateTime()
    {
        $date = $this->getExpiryDateTime();
        $this->expires_at = ($date) ? $date->format('Y-m-d') : '';
    }
}

