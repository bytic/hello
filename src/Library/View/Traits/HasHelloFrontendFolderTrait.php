<?php

namespace ByTIC\Hello\Library\View\Traits;

use ByTIC\Hello\Utility\ViewHelper;

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
        ViewHelper::registerFrontendPaths($this);
    }
}
