<?php

namespace ByTIC\Hello\Models\Users\Logins\Traits;

use ByTIC\Hello\Models\Users\Logins\UsersLogin;
use ByTIC\Hello\Models\Users\Traits\UsersTrait;
use ByTIC\Hello\Models\Users\Traits\UserTrait;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Trait LoginsTrait
 * @package ByTIC\Hello\Models\Users\Logins\Traits
 *
 * @method LoginTrait|UsersLogin getNew
 */
trait LoginsTrait
{
    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsTrait();
    }

    protected function initRelationsTrait()
    {
        $this->belongsTo('User');
    }

    /**
     * @param $providerName
     * @param $user
     * @param $userProfile
     * @return LoginTrait
     */
    public function createForProvider($providerName, $user, $userProfile)
    {
        $userLogin = $this->getNew();
        $userLogin->populateFromUser($user);
        $userLogin->populateFromUserProfile($userProfile);
        $userLogin->provider_name = $providerName;
        $userLogin->insert();

        return $userLogin;
    }

    /**
     * @param $provider
     * @param $uid
     * @return bool|UserTrait
     */
    public function getUserByProvider($provider, $uid)
    {
        $params = [
            'where' => [
                ['provider_name = ?', $provider],
                ['provider_uid = ?', $uid]
            ]
        ];

        $item = $this->findOneByParams($params);

        if ($item) {
            /** @var UsersTrait|RecordManager $userManager */
            $userManager = $this->getRelation('User')->getWith();
            return $userManager->findOne($item->id_user);
        }
        return false;
    }
}
