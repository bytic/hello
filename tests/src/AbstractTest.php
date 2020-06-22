<?php

namespace ByTIC\Hello\Tests;

use Mockery as m;
use Nip\Records\Locator\ModelLocator;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 * @package ByTIC\Hello\Tests
 */
abstract class AbstractTest extends TestCase
{

    public function tearDown() : void
    {
        parent::tearDown();
        ModelLocator::instance()->getModelRegistry()->clear();
        m::close();
    }
}
