<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class BaseTestCase extends TestCase
{
    protected \Prophecy\Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet;
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}