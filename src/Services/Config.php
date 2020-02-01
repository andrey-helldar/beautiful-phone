<?php

namespace Helldar\BeautifulPhone\Services;

use function class_exists;

use Illuminate\Support\Facades\Config as IlluminateConfig;

class Config
{
    protected static $config;

    public function get($key, $default = null)
    {
        if (empty(static::$config)) {
            static::$config = $this->load();
        }

        return static::$config[$key] ?? $default;
    }

    protected function load(): ?array
    {
        if ($this->illuminateExists() && $config = $this->illuminate()) {
            return $config;
        }

        return $this->local();
    }

    protected function local(): ?array
    {
        return require realpath(__DIR__ . '/../../config/beautiful_phone.php');
    }

    protected function illuminate(): ?array
    {
        return IlluminateConfig::get('beautiful_phone');
    }

    protected function illuminateExists(): bool
    {
        return class_exists(IlluminateConfig::class) && IlluminateConfig::getFacadeApplication();
    }
}
