<?php

namespace Helldar\BeautifulPhone\Tests;

use Helldar\BeautifulPhone\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;

class PhoneTest extends TestCase
{
    protected $phone;

    public function __construct()
    {
        parent::__construct();
    }

    public function testGet()
    {
        // Default parameters:
        $this->assertEquals("<a href='tel:456'>456</a>", app('phone')->get('456'));
        $this->assertEquals("<a href='tel:1234'>1234</a>", app('phone')->get('1234'));
        $this->assertEquals("<a href='tel:+781236622'><span>+7 (812)</span> 3-66-22</a>", app('phone')->get('fooba'));
        $this->assertEquals("<a href='tel:+7812366227'><span>+7 (812)</span> 36-62-27</a>", app('phone')->get('foobar'));
        $this->assertEquals("<a href='tel:+7812123123'><span>+7 (812)</span> 123-123</a>", app('phone')->get('123123'));
        $this->assertEquals("<a href='tel:+31234567890'><span>+3 (123)</span> 456-789-0</a>", app('phone')->get('31234567890'));
        $this->assertEquals("<a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>", app('phone')->get('+33216549883'));
        $this->assertEquals("<a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>", app('phone')->get('+33216665557'));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", app('phone')->get('+73216665557'));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", app('phone')->get('+83216665557'));

        // With manual applying city code:
        $this->assertEquals("<a href='tel:456'>456</a>", app('phone')->get('456', 1234));
        $this->assertEquals("<a href='tel:1234'>1234</a>", app('phone')->get('1234', 1234));
        $this->assertEquals("<a href='tel:+7123436622'><span>+7 (1234)</span> 3-66-22</a>", app('phone')->get('fooba', 1234));
        $this->assertEquals("<a href='tel:+71234366227'><span>+7 (1234)</span> 36-62-27</a>", app('phone')->get('foobar', 1234));
        $this->assertEquals("<a href='tel:+71234123123'><span>+7 (1234)</span> 123-123</a>", app('phone')->get('123123', 1234));
        $this->assertEquals("<a href='tel:+31234567890'><span>+3 (1234)</span> 567-890</a>", app('phone')->get('31234567890', 1234));
        $this->assertEquals("<a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>", app('phone')->get('+33216549883', 1234));
        $this->assertEquals("<a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>", app('phone')->get('+33216665557', 1234));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", app('phone')->get('+73216665557', 1234));
        $this->assertEquals("<a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>", app('phone')->get('+83216665557', 1234));

        // With disabled html formatting into phone number:
        $this->assertEquals("<a href='tel:456'>456</a>", app('phone')->get('456', 0, false));
        $this->assertEquals("<a href='tel:1234'>1234</a>", app('phone')->get('1234', 0, false));
        $this->assertEquals("<a href='tel:+781236622'>+7 (812) 3-66-22</a>", app('phone')->get('fooba', 0, false));
        $this->assertEquals("<a href='tel:+7812366227'>+7 (812) 36-62-27</a>", app('phone')->get('foobar', 0, false));
        $this->assertEquals("<a href='tel:+7812123123'>+7 (812) 123-123</a>", app('phone')->get('123123', 0, false));
        $this->assertEquals("<a href='tel:+31234567890'>+3 (123) 456-789-0</a>", app('phone')->get('31234567890', 0, false));
        $this->assertEquals("<a href='tel:+33216549883'>+3 (321) 654-98-83</a>", app('phone')->get('+33216549883', 0, false));
        $this->assertEquals("<a href='tel:+33216665557'>+3 (321) 666-555-7</a>", app('phone')->get('+33216665557', 0, false));
        $this->assertEquals("<a href='tel:+73216665557'>+7 (321) 666-555-7</a>", app('phone')->get('+73216665557', 0, false));
        $this->assertEquals("<a href='tel:+73216665557'>+7 (321) 666-555-7</a>", app('phone')->get('+83216665557', 0, false));

        // With enabled html formatting and disabled `is_link` parameter into phone number:
        $this->assertEquals('456', app('phone')->get('456', 0, true, false));
        $this->assertEquals('1234', app('phone')->get('1234', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 3-66-22', app('phone')->get('fooba', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 36-62-27', app('phone')->get('foobar', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 123-123', app('phone')->get('123123', 0, true, false));
        $this->assertEquals('<span>+3 (123)</span> 456-789-0', app('phone')->get('31234567890', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 654-98-83', app('phone')->get('+33216549883', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 666-555-7', app('phone')->get('+33216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-555-7', app('phone')->get('+73216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-555-7', app('phone')->get('+83216665557', 0, true, false));

        // With disabled html formatting and `is_link` parameter into phone number:
        $this->assertEquals('456', app('phone')->get('456', 0, false, false));
        $this->assertEquals('1234', app('phone')->get('1234', 0, false, false));
        $this->assertEquals('+7 (812) 3-66-22', app('phone')->get('fooba', 0, false, false));
        $this->assertEquals('+7 (812) 36-62-27', app('phone')->get('foobar', 0, false, false));
        $this->assertEquals('+7 (812) 123-123', app('phone')->get('123123', 0, false, false));
        $this->assertEquals('+3 (123) 456-789-0', app('phone')->get('31234567890', 0, false, false));
        $this->assertEquals('+3 (321) 654-98-83', app('phone')->get('+33216549883', 0, false, false));
        $this->assertEquals('+3 (321) 666-555-7', app('phone')->get('+33216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-555-7', app('phone')->get('+73216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-555-7', app('phone')->get('+83216665557', 0, false, false));
    }

    protected function getPackageAliases($app)
    {
        return ['Config' => Config::class];
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
