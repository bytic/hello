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
    const HELLO_NAMESPACE = 'Hello';
    const HELLO_NAMESPACE_ADMIN = 'HelloAdmin';
    const HELLO_NAMESPACE_FRONTEND = 'HelloFrontend';

    /**
     * @param View|HasHelloFrontendFolderTrait $view
     */
    public static function registerFrontendPaths(View $view)
    {
        $view->addPath(PathHelper::views('/Frontend'),);
        $view->addPath(PathHelper::views('/Frontend'), self::HELLO_NAMESPACE);
        $view->addPath(PathHelper::views('/Frontend'), self::HELLO_NAMESPACE_FRONTEND);
    }

    /**
     * @param View|HasHelloAdminFolderTrait $view
     */
    public static function registerAdminPaths(View $view)
    {
        $view->addPath(PathHelper::views('/Admin'));
        $view->addPath(PathHelper::views('/Admin'), self::HELLO_NAMESPACE);
        $view->addPath(PathHelper::views('/Admin'), self::HELLO_NAMESPACE_ADMIN);
    }
}