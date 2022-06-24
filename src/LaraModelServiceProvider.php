<?php

namespace Aditamairhamdev\LaraModel;

use Aditamairhamdev\LaraModel\Commands\MakeLaraModel;
use Illuminate\Support\ServiceProvider;

class LaraModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([MakeLaraModel::class]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
