<?php

namespace Helldar\BeautifulPhone;

use Helldar\BeautifulPhone\Services\Phone;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Laravel\Lumen\Application;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/beautiful_phone.php' => $this->app->configPath('beautiful_phone.php'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if ($this->isLumen()) {
            $this->app->configure('beautiful_phone');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/beautiful_phone.php', 'beautiful_phone');

        $this->app->singleton('phone', Phone::class);
    }

    protected function isLumen(): bool
    {
        return class_exists(Application::class) && $this->app instanceof Application;
    }
}
