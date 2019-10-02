<?php

namespace Helldar\BeautifulPhone\Services\Support;

use Illuminate\Support\Facades\Config as IlluminateConfig;

class Config
{
    private static $config;

    public static function get($key, $default = null)
    {
        if (class_exists(IlluminateConfig::class)) {
            return IlluminateConfig::get("beautiful_phone.{$key}", $default);
        }

        return static::load($key, $default);
    }

    private static function load($key, $default)
    {
        if (null === static::$config) {
            static::$config = require __DIR__ . '/../../config/beautiful_phone.php';
        }

        return static::$config[$key] ?? $default;
    }
}
