<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasOauthUser;

/**
 * @property int $user_id
 */
trait HasOauthUserRecordTrait
{
    /**
     * @param $identifier
     */
    public function setUserId($identifier)
    {
        $this->setUserIdentifier($identifier);
    }

    /**
     * @param int|string|null $identifier
     */
    public function setUserIdentifier($identifier)
    {
        $this->userIdentifier = $identifier;
        $this->setPropertyValue('user_id', $this->getUserIdentifier());
    }
}
