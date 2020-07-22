<?php

namespace Helldar\BeautifulPhone\Facades;

use Helldar\BeautifulPhone\Services\Formatter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool|string spanLink($phone, int $city_code = 0, array $attributes = [])
 * @method static bool|string cleanLink($phone, int $city_code = 0, array $attributes = [])
 * @method static bool|string span($phone, int $city_code = 0)
 * @method static bool|string clean($phone, int $city_code = 0)
 */
final class Phone extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Formatter::class;
    }
}
