<?php

namespace Helldar\BeautifulPhone\Services;

use Illuminate\Support\Facades\Config as IlluminateConfig;

use function class_exists;

class Config
{
    protected static $config;

    public function get($key, $default = null)
    {
        if (null === static::$config) {
            static::$config = $this->load();
        }

        return static::$config[$key] ?? $default;
    }

    protected function local()
    {
        return require realpath(__DIR__ . '/../../config/beautiful_phone.php');
    }

    protected function illuminate()
    {
        return IlluminateConfig::get("beautiful_phone");
    }

    protected function illuminateExists(): bool
    {
        return class_exists(IlluminateConfig::class) && IlluminateConfig::getFacadeRoot();
    }

    protected function load()
    {
        return $this->illuminateExists() ? $this->illuminate() : $this->local();
    }
}
