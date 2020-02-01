<?php

namespace Helldar\BeautifulPhone\Services;

use Illuminate\Support\Facades\Config as IlluminateConfig;

use function class_exists;

class Config
{
    protected static $config = [];

    public function get($key, $default = null)
    {
        if (empty(static::$config)) {
            static::$config = $this->load();
        }

        return static::$config[$key] ?? $default;
    }

    protected function load()
    {
        if ($this->illuminateExists() && $config = $this->illuminate()) {
            return $config;
        }

        return $this->local();
    }

    protected function local()
    {
        return require realpath(__DIR__ . '/../../config/beautiful_phone.php');
    }

    protected function illuminate()
    {
        return IlluminateConfig::get("beautiful_phone", []);
    }

    protected function illuminateExists(): bool
    {
        return class_exists(IlluminateConfig::class) && IlluminateConfig::getFacadeRoot();
    }
}
