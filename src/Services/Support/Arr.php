<?php

namespace Helldar\BeautifulPhone\Services\Support;

class Arr
{
    public static function get(array $array, string $key, $default = null)
    {
        return $array[$key] ?? $default;
    }
}