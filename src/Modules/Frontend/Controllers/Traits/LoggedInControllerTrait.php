<?php

namespace ByTIC\Hello\Modules\Frontend\Controllers\Traits;

use ByTIC\Hello\Modules\AbstractModule\Controllers\Traits\HasAuthenticationVariablesTrait;

/**
 * Trait LoggedInControllerTrait
 * @package ByTIC\Hello\Modules\Frontend\Controllers\Traits
 */
trait LoggedInControllerTrait
{
    use HasAuthenticationVariablesTrait;

    public function index()
    {
        $redirect = $this->getAuthenticationValue('redirect');
        $this->payload()->with(
            [
                'sections' => mvc_sections()->getSections()->visibleIn('menu'),
                'redirect' => $redirect,
            ]);
        $this->setLayout('login');
    }

    public function thankYou()
    {
        $this->index();
    }
}
