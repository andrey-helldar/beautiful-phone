<?php

namespace Helldar\BeautifulPhone\Tests;

use Helldar\BeautifulPhone\Services\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testGet()
    {
        $phone = new Phone();

        $this->assertEquals($phone->get('foo-bar', 0, false), '366-227');
    }
}
