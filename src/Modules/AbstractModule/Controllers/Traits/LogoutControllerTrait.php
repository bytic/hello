<?php

namespace ByTIC\Hello\Modules\AbstractModule\Controllers\Traits;

use Nip\Controllers\Traits\AbstractControllerTrait;

/**
 * Trait LogoutControllerTrait
 * @package ByTIC\Hello\Modules\AbstractModule\Controllers\Traits
 */
trait LogoutControllerTrait
{
    use AbstractControllerTrait;

    public function index()
    {
        $this->_getUser()->deauthenticate();
        $this->doSuccessRedirect();
    }

    /**
     * @return string|null
     */
    protected function getGenericRedirectURL()
    {
        $module = $this->getRequest()->getModuleName();
        return $this->Url()->assemble($module . '.logged_in');
    }

    /**
     * @inheritdoc
     */
    protected function generateModelName()
    {
        return get_class($this->_getUser()->getManager());
    }
}
