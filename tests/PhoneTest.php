<?php

namespace Helldar\BeautifulPhone\Tests;

use Helldar\BeautifulPhone\Services\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testGet()
    {
        $phone = new Phone();

        $this->assertEquals($phone->get('foobar', 0, false), '36-62-27');
        $this->assertEquals($phone->get('123123', 0, false), '123-123');
        $this->assertEquals($phone->get('555555', 0, false), '555-555');
        $this->assertEquals($phone->get('71234567890', 0, false), '+7 (123) 456-78-90');
        $this->assertEquals($phone->get('31234567890', 0, false), '+3 (123) 456-78-90');
        $this->assertEquals($phone->get('+33216549873', 0, false), '+3 (321) 654-98-73');

        $this->assertEquals($phone->get('foobar'), '<a href=\'tel:366227\'>36-62-27</a>');
        $this->assertEquals($phone->get('123123'), '<a href=\'tel:123123\'>123-123</a>');
        $this->assertEquals($phone->get('555555'), '<a href=\'tel:555555\'>555-555</a>');
        $this->assertEquals($phone->get('71234567890'), '<a href=\'tel:71234567890\'><small>+7 (123)</small> 456-78-90</a>');
        $this->assertEquals($phone->get('31234567890'), '<a href=\'tel:31234567890\'><small>+3 (123)</small> 456-78-90</a>');
        $this->assertEquals($phone->get('+33216549873'), '<a href=\'tel:33216549873\'><small>+3 (321)</small> 654-98-73</a>');
    }
}
