<?php

namespace Helldar\BeautifulPhone\Services\Support;

use Illuminate\Support\Facades\Config as IlluminateConfig;

use function class_exists;

class Config
{
    protected $config;

    public function __construct()
    {
        $this->config = $this->illuminateExists() ? $this->illuminate() : $this->local();
    }

    public function get($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    protected function illuminate()
    {
        return IlluminateConfig::get("beautiful_phone");
    }

    protected function local()
    {
        return require __DIR__ . '/../../config/beautiful_phone.php';
    }

    protected function illuminateExists(): bool
    {
        return class_exists(IlluminateConfig::class);
    }
}
