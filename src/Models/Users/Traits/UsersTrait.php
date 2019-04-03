<?php

namespace ByTIC\Hello\Models\Users\Traits;

use ByTIC\Auth\Models\Users\Traits\AbstractUsersTrait;

/**
 * Trait UsersTrait
 * @package ByTIC\Hello\Models\Users\Traits
 */
trait UsersTrait
{
    use AbstractUsersTrait {
        beforeSetCurrent as beforeSetCurrentTrait;
    }

    /**
     * @param UserTrait $item
     */
    public function beforeSetCurrent($item)
    {
        $this->beforeSetCurrentTrait($item);
        $item->checkAccessToken();
    }
}
