<?php

namespace ByTIC\Hello\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 * @package ByTIC\Hello\Tests
 */
abstract class AbstractTest extends TestCase
{

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
