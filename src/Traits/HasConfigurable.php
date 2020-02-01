<?php

namespace Helldar\BeautifulPhone\Traits;

use Helldar\BeautifulPhone\Services\Config;
use Illuminate\Container\Container;

trait HasConfigurable
{
    /** @var \Helldar\BeautifulPhone\Services\Config */
    protected static $config;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function config($key, $default = null)
    {
        if (static::$config === null) {
            static::$config = Container::getInstance()->make('Helldar\BeautifulPhone\Services\Config');
        }

        return static::$config->get($key, $default);
    }
}
