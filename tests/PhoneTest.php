<?php

namespace Helldar\BeautifulPhone\Tests;

use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testDefaultParameters()
    {
        // Default parameters:
        $this->assertEquals("<a href='tel:456'>456</a>", phone('456'));
        $this->assertEquals("<a href='tel:1234'>1234</a>", phone('1234'));
        $this->assertEquals("<a href='tel:+781236622'><span>+7 (812)</span> 3-66-22</a>", phone('fooba'));
        $this->assertEquals("<a href='tel:+7812366227'><span>+7 (812)</span> 36-62-27</a>", phone('foobar'));
        $this->assertEquals("<a href='tel:+7812123123'><span>+7 (812)</span> 123-123</a>", phone('123123'));
        $this->assertEquals("<a href='tel:+31234567890'><span>+3 (123)</span> 456-789-0</a>", phone('31234567890'));
        $this->assertEquals("<a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>", phone('+33216549883'));
        $this->assertEquals("<a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>", phone('+33216665557'));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", phone('+73216665557'));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", phone('+83216665557'));
    }

    public function testWithCityCode()
    {
        // With manual applying city code:
        $this->assertEquals("<a href='tel:456'>456</a>", phone('456', 1234));
        $this->assertEquals("<a href='tel:1234'>1234</a>", phone('1234', 1234));
        $this->assertEquals("<a href='tel:+7123436622'><span>+7 (1234)</span> 3-66-22</a>", phone('fooba', 1234));
        $this->assertEquals("<a href='tel:+71234366227'><span>+7 (1234)</span> 36-62-27</a>", phone('foobar', 1234));
        $this->assertEquals("<a href='tel:+71234123123'><span>+7 (1234)</span> 123-123</a>", phone('123123', 1234));
        $this->assertEquals("<a href='tel:+31234567890'><span>+3 (1234)</span> 567-890</a>", phone('31234567890', 1234));
        $this->assertEquals("<a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>", phone('+33216549883', 1234));
        $this->assertEquals("<a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>", phone('+33216665557', 1234));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", phone('+73216665557', 1234));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", phone('+83216665557', 1234));
    }

    public function testWithDisabledHtml()
    {
        // With disabled html formatting into phone number:
        $this->assertEquals("<a href='tel:456'>456</a>", phone('456', 0, false));
        $this->assertEquals("<a href='tel:1234'>1234</a>", phone('1234', 0, false));
        $this->assertEquals("<a href='tel:+781236622'>+7 (812) 3-66-22</a>", phone('fooba', 0, false));
        $this->assertEquals("<a href='tel:+7812366227'>+7 (812) 36-62-27</a>", phone('foobar', 0, false));
        $this->assertEquals("<a href='tel:+7812123123'>+7 (812) 123-123</a>", phone('123123', 0, false));
        $this->assertEquals("<a href='tel:+31234567890'>+3 (123) 456-789-0</a>", phone('31234567890', 0, false));
        $this->assertEquals("<a href='tel:+33216549883'>+3 (321) 654-98-83</a>", phone('+33216549883', 0, false));
        $this->assertEquals("<a href='tel:+33216665557'>+3 (321) 666-555-7</a>", phone('+33216665557', 0, false));
        $this->assertEquals("<a href='tel:+73216665557'>+7 (321) 666-555-7</a>", phone('+73216665557', 0, false));
        $this->assertEquals("<a href='tel:+73216665557'>+7 (321) 666-555-7</a>", phone('+83216665557', 0, false));
    }

    public function testWithEnabledHtmlAndDisabledLink()
    {
        // With enabled html formatting and disabled `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, true, false));
        $this->assertEquals('1234', phone('1234', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 3-66-22', phone('fooba', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 36-62-27', phone('foobar', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 123-123', phone('123123', 0, true, false));
        $this->assertEquals('<span>+3 (123)</span> 456-789-0', phone('31234567890', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 654-98-83', phone('+33216549883', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 666-555-7', phone('+33216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-555-7', phone('+73216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-555-7', phone('+83216665557', 0, true, false));
    }

    public function testWithEnabledHtmlAndEnabledLink()
    {
        // With disabled html formatting and `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, false, false));
        $this->assertEquals('1234', phone('1234', 0, false, false));
        $this->assertEquals('+7 (812) 3-66-22', phone('fooba', 0, false, false));
        $this->assertEquals('+7 (812) 36-62-27', phone('foobar', 0, false, false));
        $this->assertEquals('+7 (812) 123-123', phone('123123', 0, false, false));
        $this->assertEquals('+3 (123) 456-789-0', phone('31234567890', 0, false, false));
        $this->assertEquals('+3 (321) 654-98-83', phone('+33216549883', 0, false, false));
        $this->assertEquals('+3 (321) 666-555-7', phone('+33216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-555-7', phone('+73216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-555-7', phone('+83216665557', 0, false, false));
    }
}
