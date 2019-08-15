<?php

namespace App\Providers;

use Alias\Console\AliasModelMakeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }



    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        $this->app->alias(\App\Pagination\LengthAwarePaginator::class,\Illuminate\Pagination\LengthAwarePaginator::class);
        $this->app->singleton('ssohelper', function ($app) {
            return new \SsoAuth\AuthHelper( env('AUTH_SERVER'),env('API_SECRET'));
        });
        $this->app->alias('ssohelper',\SsoAuth\AuthHelper::class);
    }
}
