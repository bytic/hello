<?php

namespace ByTIC\Hello\Library\View\Traits;

/**
 * Trait HasAdminBaseFolderTrait
 * @package ByTIC\AdminBase\Library\View\Traits
 *
 * @method addPath($path, $namespace)
 */
trait HasHelloBaseFolderTrait
{
    /**
     * @deprecated Use addAdminBaseNamespacePath()
     */
    public function addNamespacePath()
    {
        $this->addAdminBaseNamespacePath();
    }

    public function addAdminBaseNamespacePath()
    {
        $this->addPath(__DIR__ . '/../../../../resources/themes/bootstrap3/views/', 'Hello');
    }
}
