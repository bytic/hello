<?php

namespace ByTIC\Hello\Utility;

use ByTIC\Hello\Library\View\Traits\HasHelloAdminFolderTrait;
use ByTIC\Hello\Library\View\Traits\HasHelloFrontendFolderTrait;
use Nip\View\View;

/**
 * Class ViewHelper
 * @package ByTIC\Hello\Utility
 */
class ViewHelper
{
    /**
     * @param View|HasHelloFrontendFolderTrait $view
     */
    public static function registerFrontendPaths(View $view)
    {
        $view->addPath(PathHelper::views('/Frontend'), 'Hello');
        $view->addPath(PathHelper::views('/Frontend'), 'HelloFrontend');
    }

    /**
     * @param View|HasHelloAdminFolderTrait $view
     */
    public static function registerAdminPaths(View $view)
    {
        $view->addPath(PathHelper::views('/Admin'));
        $view->addPath(PathHelper::views('/Admin'), 'Hello');
        $view->addPath(PathHelper::views('/Admin'), 'HelloAdmin');
    }
}