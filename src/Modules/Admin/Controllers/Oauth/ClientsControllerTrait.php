<?php

namespace ByTIC\Hello\Modules\Admin\Controllers\Oauth;

use ByTIC\Hello\Models\Clients\Client;
use ByTIC\Hello\Utility\RandomHelper;

/**
 * Trait ClientsControllerTrait
 * @package ByTIC\Hello\Modules\Admin\Controllers\Oauth
 * @method Client getModelFromRequest
 */
trait ClientsControllerTrait
{
    public function regenerateSecret()
    {
        $item = $this->getModelFromRequest();
        $item->setSecret(RandomHelper::generateToken());
        $item->update();
        $this->flashRedirect(
            $this->getModelManager()->getMessage('secret.reset'),
            $item->compileURL('view')
        );
    }
}
