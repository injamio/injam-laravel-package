<?php

namespace Injamio\InjamLaravelPackage;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/injam-laravel-package.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('injam-laravel-package.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'injam-laravel-package'
        );

        $this->app->bind('InjamLaravelPackage', function () {
            return new InjamLaravelPackage();
        });
    }
}
