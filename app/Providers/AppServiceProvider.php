<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //check that app is local
        if ($this->app->isLocal()) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }else{
            $this->app['request']->server->set('HTTPS', false);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->isLocal()) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
