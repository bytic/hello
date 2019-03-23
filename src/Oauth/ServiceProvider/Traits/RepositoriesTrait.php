<?php

namespace ByTIC\Hello\Oauth\ServiceProvider\Traits;

use ByTIC\Hello\Utility\ModelsHelper;

/**
 * Trait RepositoriesTrait
 * @package ByTIC\Hello\Oauth\ServiceProvider\Traits
 */
trait RepositoriesTrait
{
    public function registerRepositories()
    {
        $repositories = ModelsHelper::repositories();
        foreach ($repositories as $interface => $class) {
            $this->getContainer()->alias($class, $interface);
        }
    }

    /**
     * @param $return
     * @return array
     */
    protected function appendRepositoriesToProvide($return)
    {
        $repositories = ModelsHelper::repositories();
        foreach ($repositories as $interface => $class) {
            $return[] = $interface;
        }
        return $return;
    }
}
