<?php

namespace Alias\Providers;


use Alias\Console\AliasModelMakeCommand;
use  \Illuminate\Foundation\Providers\ArtisanServiceProvider as LaravelArtisanServiceProvider;
class AliasArtisanServiceProvider extends  LaravelArtisanServiceProvider
{
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new AliasModelMakeCommand($app['files']);
        });
    }
}