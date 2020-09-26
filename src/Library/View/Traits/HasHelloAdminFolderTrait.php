<?php

namespace ByTIC\Hello\Library\View\Traits;

use ByTIC\Hello\Utility\PathHelper;

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
        $this->addPath(PathHelper::views('/Admin'));
        $this->addPath(PathHelper::views('/Admin'), 'Hello');
    }
}
