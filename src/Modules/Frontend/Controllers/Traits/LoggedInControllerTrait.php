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
        $this->setLayout('login');
    }
}
