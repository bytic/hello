<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Trait LogoutControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait LogoutControllerTrait
{
    use AbstractControllerTrait;

    public function index()
    {
        $this->_getUser()->deauthenticate();
        $this->doSuccessRedirect();
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string|null
     */
    protected function getGenericRedirectURL()
    {
        return $this->Url()->assemble('frontend.login');
    }

    /**
     * @inheritdoc
     */
    protected function generateModelName()
    {
        return get_class(ModelLocator::get('users'));
    }
}
