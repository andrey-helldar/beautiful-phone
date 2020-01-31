<?php

namespace Helldar\BeautifulPhone\Traits;

use Helldar\BeautifulPhone\Services\Support\Config;
use Illuminate\Container\Container;

trait HasConfigurable
{
    /** @var \Helldar\BeautifulPhone\Services\Support\Config */
    protected static $config;

    /**
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function config($key, $default = null)
    {
        if (static::$config === null) {
            static::$config = Container::getInstance()->make(Config::class);
        }

        return static::$config->get($key, $default);
    }
}
