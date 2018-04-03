# Beautiful Phone for Laravel 5.4+

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
    // returned: 366-227
    
    return phone('321453')
    // returned: 32-14-53
    
    return phone('337221')
    // returned: 337-221
    
    return phone('73903402353', 0, false)
    // returned: +7 (390) 340-23-53
    
    return phone('73903402353')
    // returned: <small>+7 (390)</small> 340-23-53
    
    return phone('73903402353', 3903, false)
    // returned: +7 (3903) 40-23-53


## Copyright and License

`Laravel Beautiful Phone` was written by Andrey Helldar for the Laravel Framework 5.4 and later, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
