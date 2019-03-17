<?php

namespace ByTIC\Hello\Models\Clients\Traits;

use ByTIC\Hello\Utility\GrantsHelper;

/**
 * Trait ClientHasGrantsTrait
 * @package ByTIC\Hello\Models\Clients\Traits
 */
trait ClientHasGrantsTrait
{
    protected $grants = [];

    /**
     * @return bool
     */
    public function firstParty(): bool
    {
        return $this->hasGrant(GrantsHelper::GRANT_TYPE_USER_CREDENTIALS);
    }

    /**
     * @param string|array $grants
     * @see GrantHelper::GRANT_TYPE_*
     */
    public function addGrants($grants)
    {
        $grants = is_array($grants) ? $grants : [$grants];
        $this->setGrants(array_unique(array_merge($this->grants, $grants)));
    }

    /**
     * @param string|array $grants
     * @see GrantHelper::GRANT_TYPE_*
     */
    public function removeGrants($grants)
    {
        if (($key = array_search($grants, $this->grants)) !== false) {
            unset($this->grants[$key]);
        }
        $this->updateGrantsDbField();
    }

    /**
     * @return array
     */
    public function getGrants(): array
    {
        return $this->grants;
    }

    /**
     * @param array $grants
     */
    public function setGrants(array $grants)
    {
        $this->grants = $grants;
        $this->updateGrantsDbField();
    }

    /**
     * @param $grant
     * @return bool
     */
    public function handlesGrant($grant)
    {
        return $this->hasGrant($grant);
    }

    /**
     * @param string $grant
     * @return bool
     * @see GrantHelper::GRANT_TYPE_*
     */
    public function hasGrant(string $grant): bool
    {
        return array_search($grant, $this->grants) !== false;
    }

    protected function updateGrantsDbField()
    {
        $this->_data['grant_types'] = implode(',', $this->getGrants());
    }
}
