<?php

namespace Helldar\BeautifulPhone;

use Helldar\BeautifulPhone\Services\Phone;

use function config_path;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
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
            __DIR__ . '/config/beautiful_phone.php' => config_path('beautiful_phone.php'),
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
     */
    public function provides()
    {
        return ['phone'];
    }
}
