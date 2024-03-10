<?php

namespace Mobin\LaravelServiceKit;
use Illuminate\Support\ServiceProvider;
use Mobin\LaravelServiceKit\Console\Commands\MakeServiceClassFile;

class LaravelServiceKitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            MakeServiceClassFile::class,
        ]);
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
