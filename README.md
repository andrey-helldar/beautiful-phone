# Beautiful Phone Formatter for Laravel 5.4+

Formatting a phone number in a beautiful view.

<p align="center">
<a href="https://travis-ci.org/andrey-helldar/beautiful-phone"><img src="https://travis-ci.org/andrey-helldar/beautiful-phone.svg?branch=master&style=flat-square" alt="Build Status" /></a>
<a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://img.shields.io/packagist/dt/andrey-helldar/beautiful-phone.svg?style=flat-square" alt="Total Downloads" /></a>
<a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
<a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
<a href="https://github.com/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/license?format=flat-square" alt="License" /></a>
</p>


<p align="center">
<a href="https://www.versioneye.com/php/andrey-helldar:beautiful-phone/dev-master"><img src="https://www.versioneye.com/php/andrey-helldar:beautiful-phone/dev-master/badge?style=flat-square" alt="Dependency Status" /></a>
<a href="https://styleci.io/repos/45746985"><img src="https://styleci.io/repos/75637284/shield" alt="StyleCI" /></a>
<a href="https://php-eye.com/package/andrey-helldar/beautiful-phone"><img src="https://php-eye.com/badge/andrey-helldar/beautiful-phone/tested.svg?style=flat" alt="PHP-Eye" /></a>
</p>


## Installation

To get the latest version of Laravel Beautiful Phone, simply require the project using [Composer](https://getcomposer.org):

```
composer require andrey-helldar/beautiful-phone
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/beautiful-phone": "~1.0"
    }
}
```

If you don't use auto-discovery, add the `ServiceProvider` to the providers array in `config/app.php`:

```php
Helldar\BeautifulPhone\ServiceProvider::class,
```

You can also publish the config file to change implementations (ie. interface to specific class):

```
php artisan vendor:publish --provider="Helldar\BeautifulPhone\ServiceProvider"
```

Now you can use a `phone()` helper.


## Using

    return phone('foobar')
    // returned: <a href='tel:366227'>36-62-27</a>

    return phone('123123')
    // returned: <a href='tel:123123'>123-123</a>

    return phone('555555')
    // returned: <a href='tel:555555'>555-555</a>

    return phone('71234567890')
    // returned: <a href='tel:71234567890'><small>+7 (123)</small> 456-78-90</a>

    return phone('31234567890')
    // returned: <a href='tel:31234567890'><small>+3 (123)</small> 456-78-90</a>

    return phone('+33216549873')
    // returned: <a href='tel:33216549873'><small>+3 (321)</small> 654-98-73</a>
    
    
If you pass the area code as an attribute:
(in config: `'country_default' => 49`)

    return phone('foobar', 1234)
    // returned: <a href='tel:+491234366227'><small>+49 (1234)</small> 36-62-27</a>

    return phone('123123', 1234)
    // returned: <a href='tel:+491234123123'><small>+49 (1234)</small> 123-123</a>

    return phone('555555', 1234)
    // returned: <a href='tel:+491234555555'><small>+49 (1234)</small> 555-555</a>

    return phone('71234567890', 1234)
    // returned: <a href='tel:71234567890'><small>+7 (123)</small> 456-78-90</a>

    return phone('31234567890', 1234)
    // returned: <a href='tel:31234567890'><small>+3 (123)</small> 456-78-90</a>

    return phone('+33216549873', 1234)
    // returned: <a href='tel:33216549873'><small>+3 (321)</small> 654-98-73</a>

If we pass into the attribute the prohibition on the formation of a telephone number in html format:


    return phone('foobar', 0, false)
    // returned: 36-62-27

    return phone('123123', 0, false)
    // returned: 123-123

    return phone('555555', 0, false)
    // returned: 555-555

    return phone('71234567890', 0, false)
    // returned: +7 (123) 456-78-90

    return phone('31234567890', 0, false)
    // returned: +3 (123) 456-78-90

    return phone('+33216549873', 0, false)
    // returned: +3 (321) 654-98-73


## Copyright and License

`Laravel Beautiful Phone` was written by Andrey Helldar for the Laravel Framework 5.4 and later, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
