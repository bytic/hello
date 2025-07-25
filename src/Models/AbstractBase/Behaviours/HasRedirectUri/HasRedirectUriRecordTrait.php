<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasRedirectUri;

/**
 * @property string $redirect_uri
 */
trait HasRedirectUriRecordTrait
{
    /**
     * @inheritDoc
     */
    public function getRedirectUri()
    {
        $redirectUri = $this->getPropertyRaw('redirect_uri');
        return $redirectUri;
    }

    /**
     * @param $redirect
     * @return self
     */
    public function setRedirectUri($redirect)
    {
        $this->setPropertyValue('redirect_uri', $redirect);
        $this->redirectUri = $redirect;
        return $this;
    }
}