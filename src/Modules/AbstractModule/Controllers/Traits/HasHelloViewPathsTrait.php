<?php

namespace ByTIC\Hello\Modules\AbstractModule\Controllers\Traits;

use ByTIC\Hello\Utility\ViewHelper;

/**
 * Trait HasHelloViewPathsTraitHasHelloViewPathsTrait
 * @package ByTIC\Hello\Modules\AbstractModule\Controllers\Traits
 */
trait HasHelloViewPathsTrait
{
    protected function bootHasHelloViewPathsTrait()
    {
        $this->after(
            function () {
                $this->registerHelloViewPaths();
            }
        );
    }

    protected function registerHelloViewPaths()
    {
        $view = $this->getView();
        $module = request()->getModuleName();
        if ($module == 'admin') {
            ViewHelper::registerAdminPaths($view);
        }
        ViewHelper::registerFrontendPaths($view);
    }
}