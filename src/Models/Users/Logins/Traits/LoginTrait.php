<?php

namespace ByTIC\Hello\Models\Users\Logins\Traits;

use ByTIC\Hello\Models\Users\Traits\UserTrait;
use Hybrid_User_Profile;

/**
 * Trait LoginTrait
 * @package ByTIC\Hello\Models\Users\Logins\Traits
 *
 * @property int $id_user
 * @property string $provider_name
 * @property string $provider_uid
 *
 */
trait LoginTrait
{
    /**
     * @param UserTrait $user
     */
    public function populateFromUser($user)
    {
        $this->id_user = $user->id;
    }

    /**
     * @param Hybrid_User_Profile $profile
     */
    public function populateFromUserProfile($profile)
    {
        $this->provider_uid = $profile->identifier;
    }
}
