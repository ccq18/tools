<?php

namespace App\Providers;

use Auth;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Ido\Tools\SsoAuth\SsoUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::provider('sso_authorization', function () {
            return new SsoUserProvider();
        });
        \Auth::provider('eloquent', function ($app, $config) {
            return new EloquentUserProvider($this->app['hash'], $config['model']);
        });
        //
    }
}
