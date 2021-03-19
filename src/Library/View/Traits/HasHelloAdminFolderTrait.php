<?php

namespace ByTIC\Hello\Library\View\Traits;

use ByTIC\Hello\Utility\ViewHelper;

/**
 * Trait HasAdminBaseFolderTrait
 * @package ByTIC\Hello\Library\View\Traits
 *
 * @method addPath($path, $namespace = null)
 */
trait HasHelloAdminFolderTrait
{
    public function addHelloAdminNamespacePath()
    {
        ViewHelper::registerAdminPaths($this);
    }
}
