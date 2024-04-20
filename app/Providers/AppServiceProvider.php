<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use PackageVersions\Versions as Package;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('illuminate.version', Application::VERSION);

        $this->app->singleton('package.version', function($app) {
            return $this->getPackageVersion('propaganistas/laravel-phone');
        });

        $this->app->singleton('libphonenumber.version', function($app) {
            return $this->getPackageVersion('giggsey/libphonenumber-for-php-lite');
        });
    }

    /**
     * @param $package
     * @return string
     */
    protected function getPackageVersion($package)
    {
        return Str::before(Package::getVersion($package), '@');
    }
}
