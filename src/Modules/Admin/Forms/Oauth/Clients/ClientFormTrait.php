<?php

namespace ByTIC\Hello\Modules\Admin\Forms\Oauth\Clients;

/**
 * Trait ClientFormTrait
 * @package ByTIC\Hello\Modules\Admin\Forms\Oauth\Clients
 */
trait ClientFormTrait
{
    public function init()
    {
        parent::init();

        $this->addInput('name', translator()->trans('name'), true);
        $this->addInput('redirect', translator()->trans('redirect'), true);

        $this->addButton('submit', translator()->trans('submit'));
    }
}
