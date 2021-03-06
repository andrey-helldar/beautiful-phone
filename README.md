# Beautiful Phone Formatter

Formatting a phone number into a beautiful view.

![beautiful phone](https://user-images.githubusercontent.com/10347617/66074886-f3b82c80-e562-11e9-80b1-ba731deba9f3.png)

> This package is abandoned and no longer maintained. The author suggests using the [propaganistas/laravel-phone](https://github.com/Propaganistas/Laravel-Phone) package instead.

<p align="center">
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://img.shields.io/packagist/dt/andrey-helldar/beautiful-phone.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
</p>

<p align="center">
    <a href="https://styleci.io/repos/127879322"><img src="https://styleci.io/repos/127879322/shield" alt="StyleCI" /></a>
    <a href="https://travis-ci.org/andrey-helldar/beautiful-phone"><img src="https://travis-ci.org/andrey-helldar/beautiful-phone.svg?branch=master" alt="Travis-CI" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/license?format=flat-square" alt="License" /></a>
</p>


## Installation

To get the latest version of `Beautiful Phone Formatter`, simply require the project using [Composer](https://getcomposer.org):

```
composer require andrey-helldar/beautiful-phone
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "andrey-helldar/beautiful-phone": "^2.1"
    }
}
```


### Laravel

You can also publish the config file to change implementations (ie. interface to specific class):

```shell script
php artisan vendor:publish --provider="Helldar\BeautifulPhone\ServiceProvider"
```


### Lumen

This package is focused on Laravel development, but it can also be used in Lumen with some workarounds. Because Lumen works a little different, as it is like a barebone version of Laravel and the main configuration parameters are instead located in `bootstrap/app.php`, some alterations must be made.

You can install the package in `app/Providers/AppServiceProvider.php`, and uncommenting this line that registers the App Service Providers so it can properly load.

```php
// $app->register(App\Providers\AppServiceProvider::class);
```

If you are not using that line, that is usually handy to manage gracefully multiple Lumen installations, you will have to add this line of code under the `Register Service Providers `section of your `bootstrap/app.php`.

```
$app->register(\Helldar\BeautifulPhone\ServiceProvider::class);
```


## Using

Now you can use the universal `phone()` helper inside the Laravel Framework (`phone()` too working).

Or create a `Phone` instance:
```php
use Helldar\BeautifulPhone\Services\Phone;

return (new Phone())->get(/*...params...*/);
```


### Default parameters:

```php
return phone('4567');
// returned: <a href='tel:4567'>4567</a>

return phone('fooba');
// returned: <a href='tel:+781236622'><span>+7 (812)</span> 3-66-22</a>

return phone('foobar');
// returned: <a href='tel:+7812366227'><span>+7 (812)</span> 36-62-27</a>

return phone('123123');
// returned: <a href='tel:+7812123123'><span>+7 (812)</span> 123-123</a>

return phone('31234567890');
// returned: <a href='tel:+31234567890'><span>+3 (123)</span> 456-789-0</a>

return phone('+33216549883');
// returned: <a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>

return phone('+33216665557');
// returned: <a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>

return phone('+73216665557');
// returned: <a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>

return phone('+83216665557');
// returned: <a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>
```


### With manual applying city code:

```php
return phone('4567', 1234);
// returned: <a href='tel:4567'>4567</a>

return phone('fooba', 1234);
// returned: <a href='tel:+7123436622'><span>+7 (1234)</span> 3-66-22</a>

return phone('foobar', 1234);
// returned: <a href='tel:+71234366227'><span>+7 (1234)</span> 36-62-27</a>

return phone('123123', 1234);
// returned: <a href='tel:+71234123123'><span>+7 (1234)</span> 123-123</a>

return phone('31234567890', 1234);
// returned: <a href='tel:+31234567890'><span>+3 (1234)</span> 567-890</a>

return phone('+33216549883', 1234);
// returned: <a href='tel:+33216549883'><span>+3 (321)</span> 654-98-83</a>

return phone('+33216665557', 1234);
// returned: <a href='tel:+33216665557'><span>+3 (321)</span> 666-555-7</a>

return phone('+73216665557', 1234);
// returned: <a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>

return phone('+83216665557', 1234);
// returned: <a href='tel:+73216665557'><span>+7 (321)</span> 666-555-7</a>
```

### With disabled html formatting into phone number:

```php
return phone('4567', 0, false);
// returned: <a href='tel:4567'>4567</a>

return phone('fooba', 0, false);
// returned: <a href='tel:+781236622'>+7 (812) 3-66-22</a>

return phone('foobar', 0, false);
// returned: <a href='tel:+7812366227'>+7 (812) 36-62-27</a>

return phone('123123', 0, false);
// returned: <a href='tel:+7812123123'>+7 (812) 123-123</a>

return phone('31234567890', 0, false);
// returned: <a href='tel:+31234567890'>+3 (123) 456-789-0</a>

return phone('+33216549883', 0, false);
// returned: <a href='tel:+33216549883'>+3 (321) 654-98-83</a>

return phone('+33216665557', 0, false);
// returned: <a href='tel:+33216665557'>+3 (321) 666-555-7</a>

return phone('+73216665557', 0, false);
// returned: <a href='tel:+73216665557'>+7 (321) 666-555-7</a>

return phone('+83216665557', 0, false);
// returned: <a href='tel:+73216665557'>+7 (321) 666-555-7</a>
```

### With enabled html formatting and disabled `is_link` parameter into phone number:

```php
return phone('4567', 0, true, false);
// returned: 4567

return phone('fooba', 0, true, false);
// returned: <span>+7 (812)</span> 3-66-22

return phone('foobar', 0, true, false);
// returned: <span>+7 (812)</span> 36-62-27

return phone('123123', 0, true, false);
// returned: <span>+7 (812)</span> 123-123

return phone('31234567890', 0, true, false);
// returned: <span>+3 (123)</span> 456-789-0

return phone('+33216549883', 0, true, false);
// returned: <span>+3 (321)</span> 654-98-83

return phone('+33216665557', 0, true, false);
// returned: <span>+3 (321)</span> 666-555-7

return phone('+73216665557', 0, true, false);
// returned: <span>+7 (321)</span> 666-555-7

return phone('+83216665557', 0, true, false);
// returned: <span>+7 (321)</span> 666-555-7
```

### With disabled html formatting and `is_link` parameter into phone number:

```php
return phone('4567', 0, false, false);
// returned: 4567

return phone('fooba', 0, false, false);
// returned: +7 (812) 3-66-22

return phone('foobar', 0, false, false);
// returned: +7 (812) 36-62-27

return phone('123123', 0, false, false);
// returned: +7 (812) 123-123

return phone('31234567890', 0, false, false);
// returned: +3 (123) 456-789-0

return phone('+33216549883', 0, false, false);
// returned: +3 (321) 654-98-83

return phone('+33216665557', 0, false, false);
// returned: +3 (321) 666-555-7

return phone('+73216665557', 0, false, false);
// returned: +7 (321) 666-555-7

return phone('+83216665557', 0, false, false);
// returned: +7 (321) 666-555-7
```

### With full clear attribute:

```php
return phone('4567', 0, false, false, [], true);
// returned: 4567

return phone('fooba', 0, false, false, [], true);
// returned: +781236622

return phone('foobar', 0, false, false, [], true);
// returned: +7812366227

return phone('123123', 0, false, false, [], true);
// returned: +7812123123

return phone('31234567890', 0, false, false, [], true);
// returned: +31234567890

return phone('+33216549883', 0, false, false, [], true);
// returned: +33216549883

return phone('+33216665557', 0, false, false, [], true);
// returned: +33216665557

return phone('+73216665557', 0, false, false, [], true);
// returned: +73216665557

return phone('+83216665557', 0, false, false, [], true);
// returned: +73216665557
```

### With additional attributes:

```php
$attributes = ["id" => "foo", "class" => "bar baz", "data-value" => "foo"];

// Default parameters:
return phone('foobar', 0, true, true, $attributes);
// returned: <a href="tel:+7812366227" id="foo" class="bar baz" data-value="foo"><span>+7 (812)</span> 36-62-27</a>

// With manual applying city code:
return phone('foobar', 1234, true, true, $attributes);
// returned: <a href="tel:+71234366227" id="foo" class="bar baz" data-value="foo"><span>+7 (1234)</span> 36-62-27</a>

// With disabled html formatting into phone number:
return phone('foobar', 0, false, true, $attributes);
// returned: <a href="tel:+7812366227" id="foo" class="bar baz" data-value="foo">+7 (812) 36-62-27</a>

// With enabled html formatting and disabled `is_link` parameter into phone number:
return phone('foobar', 0, true, false, $attributes);
// returned: <span>+7 (812)</span> 36-62-27

// With disabled html formatting and `is_link` parameter into phone number:
return phone('foobar', 0, false, false, $attributes);
// returned: +7 (812) 36-62-27
```


### Laravel/Lumen facade

If you are using the Laravel or Lumen framework, then you can use the `Phone` facade call:

```php
use Helldar\BeautifulPhone\Facades\Phone;

return Phone::spanLink('foobar');
// returned: <a href='tel:+7812366227'><span>+7 (812)</span> 36-62-27</a>

return Phone::cleanLink('foobar');
// returned: <a href='tel:+7812366227'>+7 (812) 36-62-27</a>

return Phone::span('foobar');
// returned: <span>+7 (812)</span> 36-62-27

return Phone::clear('foobar');
// returned: +7 (812) 36-62-27

return Phone::fullClear('foobar');
// returned: +7812366227
```


## Copyright and License

`Beautiful Phone Formatter` was written by Andrey Helldar, and is released under the [MIT LICENSE](LICENSE).
