<?php

namespace Ido\Tools\Util;

use Illuminate\Support\ServiceProvider;


class UtilProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DbHelper::class, function () {
            return new DbHelper(\Config::get('database.connections.mysql.host'),\Config::get('database.connections.mysql.database'),\Config::get('database.connections.mysql.username'),\Config::get('database.connections.mysql.password'),\Config::get('database.connections.mysql.port'));
        });

    }

}