<?php

namespace App\Providers;

use ApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(\Wonde\Client::class, function ($app) {
            return new \Wonde\Client(config('app.wonde.auth_token'));
        });
    }
}
