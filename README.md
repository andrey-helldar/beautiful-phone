# Beautiful Phone Formatter for Laravel 5.4+

Formatting a phone number into a beautiful view.

![beautiful phone](https://user-images.githubusercontent.com/10347617/40197723-f1da55e6-5a1c-11e8-8b20-f8ecedd5718d.png)

<p align="center">
    <a href="https://styleci.io/repos/45746985"><img src="https://styleci.io/repos/75637284/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://img.shields.io/packagist/dt/andrey-helldar/beautiful-phone.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/beautiful-phone"><img src="https://poser.pugx.org/andrey-helldar/beautiful-phone/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
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
        "andrey-helldar/beautiful-phone": "^1.1"
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

### Default parameters:

```php
return phone('fooba')
// returned: <a href='tel:781236622'><span>+7 (812)</span> 3-66-22</a>

return phone('foobar')
// returned: <a href='tel:7812366227'><span>+7 (812)</span> 36-62-27</a>

return phone('123123')
// returned: <a href='tel:7812123123'><span>+7 (812)</span> 123-123</a>

return phone('31234567890')
// returned: <a href='tel:31234567890'><span>+3 (123)</span> 456-789-0</a>

return phone('+33216549883')
// returned: <a href='tel:33216549883'><span>+3 (321)</span> 654-98-83</a>

return phone('+33216665557')
// returned: <a href='tel:33216665557'><span>+3 (321)</span> 666-555-7</a>
```


### With manual applying city code:

```php
return phone('fooba', 1234)
// returned: <a href='tel:7123436622'><span>+7 (1234)</span> 3-66-22</a>

return phone('foobar', 1234)
// returned: <a href='tel:71234366227'><span>+7 (1234)</span> 36-62-27</a>

return phone('123123', 1234)
// returned: <a href='tel:71234123123'><span>+7 (1234)</span> 123-123</a>

return phone('31234567890', 1234)
// returned: <a href='tel:31234567890'><span>+3 (1234)</span> 567-890</a>

return phone('+33216549883', 1234)
// returned: <a href='tel:33216549883'><span>+3 (321)</span> 654-98-83</a>

return phone('+33216665557', 1234)
// returned: <a href='tel:33216665557'><span>+3 (321)</span> 666-555-7</a>
```

### With disabled html formatting into phone number:

```php
return phone('fooba', 0, false)
// returned: <a href='tel:781236622'>+7 (812) 3-66-22</a>

return phone('foobar', 0, false)
// returned: <a href='tel:7812366227'>+7 (812) 36-62-27</a>

return phone('123123', 0, false)
// returned: <a href='tel:7812123123'>+7 (812) 123-123</a>

return phone('31234567890', 0, false)
// returned: <a href='tel:31234567890'>+3 (123) 456-789-0</a>

return phone('+33216549883', 0, false)
// returned: <a href='tel:33216549883'>+3 (321) 654-98-83</a>

return phone('+33216665557', 0, false)
// returned: <a href='tel:33216665557'>+3 (321) 666-555-7</a>
```

### With enabled html formatting and disabled `is_link` parameter into phone number:

```php
return phone('fooba', 0, true, false)
// returned: <span>+7 (812)</span> 3-66-22

return phone('foobar', 0, true, false)
// returned: <span>+7 (812)</span> 36-62-27

return phone('123123', 0, true, false)
// returned: <span>+7 (812)</span> 123-123

return phone('31234567890', 0, true, false)
// returned: <span>+3 (123)</span> 456-789-0

return phone('+33216549883', 0, true, false)
// returned: <span>+3 (321)</span> 654-98-83

return phone('+33216665557', 0, true, false)
// returned: <span>+3 (321)</span> 666-555-7
```

### With disabled html formatting and `is_link` parameter into phone number:

```php
return phone('fooba', 0, false, false)
// returned: +7 (812) 3-66-22

return phone('foobar', 0, false, false)
// returned: +7 (812) 36-62-27

return phone('123123', 0, false, false)
// returned: +7 (812) 123-123

return phone('31234567890', 0, false, false)
// returned: +3 (123) 456-789-0

return phone('+33216549883', 0, false, false)
// returned: +3 (321) 654-98-83

return phone('+33216665557', 0, false, false)
// returned: +3 (321) 666-555-7
```


## Copyright and License

`Beautiful Phone Formatter` was written by Andrey Helldar for the Laravel Framework 5.4 and later, and is released under the [MIT LICENSE](LICENSE).
