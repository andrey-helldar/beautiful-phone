<?php

namespace Tests;

use Helldar\BeautifulPhone\Support\Config;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $beauty = true;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('enabled', $this->beauty);
    }
}
