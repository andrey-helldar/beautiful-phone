<?php

namespace Tests;

class StockPhoneTest extends TestCase
{
    protected $beauty = false;

    private $attributes = ['id' => 'foo', 'class' => 'bar baz', 'data-value' => 'foo'];

    public function testDefaultParameters()
    {
        // Default parameters:
        $this->assertEquals('<a href="tel:456">456</a>', phone('456'));
        $this->assertEquals('<a href="tel:1234">1234</a>', phone('1234'));
        $this->assertEquals('<a href="tel:+781236622"><span>+7 (812)</span> 3-66-22</a>', phone('fooba'));
        $this->assertEquals('<a href="tel:+7812366227"><span>+7 (812)</span> 36-62-27</a>', phone('foobar'));
        $this->assertEquals('<a href="tel:+7812123123"><span>+7 (812)</span> 12-31-23</a>', phone('123123'));
        $this->assertEquals('<a href="tel:+31234567890"><span>+3 (123)</span> 456-78-90</a>', phone('31234567890'));
        $this->assertEquals('<a href="tel:+33216549883"><span>+3 (321)</span> 654-98-83</a>', phone('+33216549883'));
        $this->assertEquals('<a href="tel:+33216665557"><span>+3 (321)</span> 666-55-57</a>', phone('+33216665557'));
        $this->assertEquals('<a href="tel:+73216665557"><span>+7 (321)</span> 666-55-57</a>', phone('+73216665557'));
        $this->assertEquals('<a href="tel:+73216665557"><span>+7 (321)</span> 666-55-57</a>', phone('+83216665557'));
    }

    public function testWithCityCode()
    {
        // With manual applying city code:
        $this->assertEquals('<a href="tel:456">456</a>', phone('456', 1234));
        $this->assertEquals('<a href="tel:1234">1234</a>', phone('1234', 1234));
        $this->assertEquals('<a href="tel:+7123436622"><span>+7 (1234)</span> 3-66-22</a>', phone('fooba', 1234));
        $this->assertEquals('<a href="tel:+71234366227"><span>+7 (1234)</span> 36-62-27</a>', phone('foobar', 1234));
        $this->assertEquals('<a href="tel:+71234123123"><span>+7 (1234)</span> 12-31-23</a>', phone('123123', 1234));
        $this->assertEquals('<a href="tel:+31234567890"><span>+3 (1234)</span> 56-78-90</a>', phone('31234567890', 1234));
        $this->assertEquals('<a href="tel:+33216549883"><span>+3 (321)</span> 654-98-83</a>', phone('+33216549883', 1234));
        $this->assertEquals('<a href="tel:+33216665557"><span>+3 (321)</span> 666-55-57</a>', phone('+33216665557', 1234));
        $this->assertEquals('<a href="tel:+73216665557"><span>+7 (321)</span> 666-55-57</a>', phone('+73216665557', 1234));
        $this->assertEquals('<a href="tel:+73216665557"><span>+7 (321)</span> 666-55-57</a>', phone('+83216665557', 1234));
    }

    public function testWithDisabledHtml()
    {
        // With disabled html formatting into phone number:
        $this->assertEquals('<a href="tel:456">456</a>', phone('456', 0, false));
        $this->assertEquals('<a href="tel:1234">1234</a>', phone('1234', 0, false));
        $this->assertEquals('<a href="tel:+781236622">+7 (812) 3-66-22</a>', phone('fooba', 0, false));
        $this->assertEquals('<a href="tel:+7812366227">+7 (812) 36-62-27</a>', phone('foobar', 0, false));
        $this->assertEquals('<a href="tel:+7812123123">+7 (812) 12-31-23</a>', phone('123123', 0, false));
        $this->assertEquals('<a href="tel:+31234567890">+3 (123) 456-78-90</a>', phone('31234567890', 0, false));
        $this->assertEquals('<a href="tel:+33216549883">+3 (321) 654-98-83</a>', phone('+33216549883', 0, false));
        $this->assertEquals('<a href="tel:+33216665557">+3 (321) 666-55-57</a>', phone('+33216665557', 0, false));
        $this->assertEquals('<a href="tel:+73216665557">+7 (321) 666-55-57</a>', phone('+73216665557', 0, false));
        $this->assertEquals('<a href="tel:+73216665557">+7 (321) 666-55-57</a>', phone('+83216665557', 0, false));
    }

    public function testWithEnabledHtmlAndDisabledLink()
    {
        // With enabled html formatting and disabled `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, true, false));
        $this->assertEquals('1234', phone('1234', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 3-66-22', phone('fooba', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 36-62-27', phone('foobar', 0, true, false));
        $this->assertEquals('<span>+7 (812)</span> 12-31-23', phone('123123', 0, true, false));
        $this->assertEquals('<span>+3 (123)</span> 456-78-90', phone('31234567890', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 654-98-83', phone('+33216549883', 0, true, false));
        $this->assertEquals('<span>+3 (321)</span> 666-55-57', phone('+33216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-55-57', phone('+73216665557', 0, true, false));
        $this->assertEquals('<span>+7 (321)</span> 666-55-57', phone('+83216665557', 0, true, false));
    }

    public function testWithEnabledHtmlAndEnabledLink()
    {
        // With disabled html formatting and `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, false, false));
        $this->assertEquals('1234', phone('1234', 0, false, false));
        $this->assertEquals('+7 (812) 3-66-22', phone('fooba', 0, false, false));
        $this->assertEquals('+7 (812) 36-62-27', phone('foobar', 0, false, false));
        $this->assertEquals('+7 (812) 12-31-23', phone('123123', 0, false, false));
        $this->assertEquals('+3 (123) 456-78-90', phone('31234567890', 0, false, false));
        $this->assertEquals('+3 (321) 654-98-83', phone('+33216549883', 0, false, false));
        $this->assertEquals('+3 (321) 666-55-57', phone('+33216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-55-57', phone('+73216665557', 0, false, false));
        $this->assertEquals('+7 (321) 666-55-57', phone('+83216665557', 0, false, false));
    }

    public function testDefaultParametersWithAttributes()
    {
        // Default parameters:
        $this->assertEquals(
            '<a href="tel:456" id="foo" class="bar baz" data-value="foo">456</a>',
            phone('456', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:1234" id="foo" class="bar baz" data-value="foo">1234</a>',
            phone('1234', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+781236622" id="foo" class="bar baz" data-value="foo"><span>+7 (812)</span> 3-66-22</a>',
            phone('fooba', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+7812366227" id="foo" class="bar baz" data-value="foo"><span>+7 (812)</span> 36-62-27</a>',
            phone('foobar', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+7812123123" id="foo" class="bar baz" data-value="foo"><span>+7 (812)</span> 12-31-23</a>',
            phone('123123', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+31234567890" id="foo" class="bar baz" data-value="foo"><span>+3 (123)</span> 456-78-90</a>',
            phone('31234567890', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216549883" id="foo" class="bar baz" data-value="foo"><span>+3 (321)</span> 654-98-83</a>',
            phone('+33216549883', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216665557" id="foo" class="bar baz" data-value="foo"><span>+3 (321)</span> 666-55-57</a>',
            phone('+33216665557', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo"><span>+7 (321)</span> 666-55-57</a>',
            phone('+73216665557', 0, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo"><span>+7 (321)</span> 666-55-57</a>',
            phone('+83216665557', 0, true, true, $this->attributes)
        );
    }

    public function testWithCityCodeWithAttributes()
    {
        // With manual applying city code:
        $this->assertEquals(
            '<a href="tel:456" id="foo" class="bar baz" data-value="foo">456</a>',
            phone('456', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:1234" id="foo" class="bar baz" data-value="foo">1234</a>',
            phone('1234', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+7123436622" id="foo" class="bar baz" data-value="foo"><span>+7 (1234)</span> 3-66-22</a>',
            phone('fooba', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+71234366227" id="foo" class="bar baz" data-value="foo"><span>+7 (1234)</span> 36-62-27</a>',
            phone('foobar', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+71234123123" id="foo" class="bar baz" data-value="foo"><span>+7 (1234)</span> 12-31-23</a>',
            phone('123123', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+31234567890" id="foo" class="bar baz" data-value="foo"><span>+3 (1234)</span> 56-78-90</a>',
            phone('31234567890', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216549883" id="foo" class="bar baz" data-value="foo"><span>+3 (321)</span> 654-98-83</a>',
            phone('+33216549883', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216665557" id="foo" class="bar baz" data-value="foo"><span>+3 (321)</span> 666-55-57</a>',
            phone('+33216665557', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo"><span>+7 (321)</span> 666-55-57</a>',
            phone('+73216665557', 1234, true, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo"><span>+7 (321)</span> 666-55-57</a>',
            phone('+83216665557', 1234, true, true, $this->attributes)
        );
    }

    public function testWithDisabledHtmlWithAttributes()
    {
        // With disabled html formatting into phone number:
        $this->assertEquals(
            '<a href="tel:456" id="foo" class="bar baz" data-value="foo">456</a>',
            phone('456', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:1234" id="foo" class="bar baz" data-value="foo">1234</a>',
            phone('1234', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+781236622" id="foo" class="bar baz" data-value="foo">+7 (812) 3-66-22</a>',
            phone('fooba', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+7812366227" id="foo" class="bar baz" data-value="foo">+7 (812) 36-62-27</a>',
            phone('foobar', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+7812123123" id="foo" class="bar baz" data-value="foo">+7 (812) 12-31-23</a>',
            phone('123123', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+31234567890" id="foo" class="bar baz" data-value="foo">+3 (123) 456-78-90</a>',
            phone('31234567890', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216549883" id="foo" class="bar baz" data-value="foo">+3 (321) 654-98-83</a>',
            phone('+33216549883', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+33216665557" id="foo" class="bar baz" data-value="foo">+3 (321) 666-55-57</a>',
            phone('+33216665557', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo">+7 (321) 666-55-57</a>',
            phone('+73216665557', 0, false, true, $this->attributes)
        );

        $this->assertEquals(
            '<a href="tel:+73216665557" id="foo" class="bar baz" data-value="foo">+7 (321) 666-55-57</a>',
            phone('+83216665557', 0, false, true, $this->attributes)
        );
    }

    public function testWithEnabledHtmlAndDisabledLinkWithAttributes()
    {
        // With enabled html formatting and disabled `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, true, false, $this->attributes));
        $this->assertEquals('1234', phone('1234', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+7 (812)</span> 3-66-22', phone('fooba', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+7 (812)</span> 36-62-27', phone('foobar', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+7 (812)</span> 12-31-23', phone('123123', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+3 (123)</span> 456-78-90', phone('31234567890', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+3 (321)</span> 654-98-83', phone('+33216549883', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+3 (321)</span> 666-55-57', phone('+33216665557', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+7 (321)</span> 666-55-57', phone('+73216665557', 0, true, false, $this->attributes));
        $this->assertEquals('<span>+7 (321)</span> 666-55-57', phone('+83216665557', 0, true, false, $this->attributes));
    }

    public function testWithEnabledHtmlAndEnabledLinkWithAttributes()
    {
        // With disabled html formatting and `is_link` parameter into phone number:
        $this->assertEquals('456', phone('456', 0, false, false, $this->attributes));
        $this->assertEquals('1234', phone('1234', 0, false, false, $this->attributes));
        $this->assertEquals('+7 (812) 3-66-22', phone('fooba', 0, false, false, $this->attributes));
        $this->assertEquals('+7 (812) 36-62-27', phone('foobar', 0, false, false, $this->attributes));
        $this->assertEquals('+7 (812) 12-31-23', phone('123123', 0, false, false, $this->attributes));
        $this->assertEquals('+3 (123) 456-78-90', phone('31234567890', 0, false, false, $this->attributes));
        $this->assertEquals('+3 (321) 654-98-83', phone('+33216549883', 0, false, false, $this->attributes));
        $this->assertEquals('+3 (321) 666-55-57', phone('+33216665557', 0, false, false, $this->attributes));
        $this->assertEquals('+7 (321) 666-55-57', phone('+73216665557', 0, false, false, $this->attributes));
        $this->assertEquals('+7 (321) 666-55-57', phone('+83216665557', 0, false, false, $this->attributes));
    }

    public function testFullClean()
    {
        $this->assertEquals('456', phone('456', 0, false, false, [], true));
        $this->assertEquals('1234', phone('1234', 0, false, false, [], true));
        $this->assertEquals('+781236622', phone('fooba', 0, false, false, [], true));
        $this->assertEquals('+7812366227', phone('foobar', 0, false, false, [], true));
        $this->assertEquals('+7812123123', phone('123123', 0, false, false, [], true));
        $this->assertEquals('+31234567890', phone('31234567890', 0, false, false, [], true));
        $this->assertEquals('+33216549883', phone('+33216549883', 0, false, false, [], true));
        $this->assertEquals('+33216665557', phone('+33216665557', 0, false, false, [], true));
        $this->assertEquals('+73216665557', phone('+73216665557', 0, false, false, [], true));
        $this->assertEquals('+73216665557', phone('+83216665557', 0, false, false, [], true));
    }
}
