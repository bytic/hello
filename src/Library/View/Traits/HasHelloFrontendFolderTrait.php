<?php

namespace ByTIC\Hello\Library\View\Traits;

use ByTIC\Hello\Utility\PathHelper;

/**
 * Trait HasAdminBaseFolderTrait
 * @package ByTIC\AdminBase\Library\View\Traits
 *
 * @method addPath($path, $namespace)
 */
trait HasHelloFrontendFolderTrait
{
    public function addHelloFrontendNamespacePath()
    {
        $this->addPath(PathHelper::views('/Frontend'), 'Hello');
        $this->addPath(PathHelper::views('/Frontend'), 'HelloFrontend');
    }
}
