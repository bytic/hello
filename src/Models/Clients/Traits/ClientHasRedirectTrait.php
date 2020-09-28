<?php

namespace ByTIC\Hello\Models\Clients\Traits;

/**
 * Trait ClientHasRedirectTrait
 * @package ByTIC\Hello\Models\Clients\Traits
 *
 * @property string $redirect
 */
trait ClientHasRedirectTrait
{
    /**
     * @param $redirect
     * @return string
     */
    public function setRedirectUri($redirect)
    {
        $this->redirect = $redirect;
        $this->redirectUri = $redirect;
        return $this;
    }
}
