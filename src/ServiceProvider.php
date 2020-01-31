<?php

namespace Helldar\BeautifulPhone;

use Helldar\BeautifulPhone\Services\Phone;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/beautiful_phone.php' => $this->app->configPath('beautiful_phone.php'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/beautiful_phone.php', 'beautiful_phone');

        $this->app->singleton('phone', Phone::class);
    }

    /**
     * {@inheritdoc}
     * @deprecated The `app('phone)` helper will be removed from the package in version 2.0.
     */
    public function provides()
    {
        return ['phone'];
    }
}
