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
        $this->app->instance('package.version', $this->getPackageVersion('propaganistas/laravel-phone'));
        $this->app->instance('libphonenumber.version', $this->getPackageVersion('giggsey/libphonenumber-for-php'));
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
