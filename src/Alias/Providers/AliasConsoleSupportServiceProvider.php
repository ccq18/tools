<?php

namespace Alias\Providers;

use \Illuminate\Foundation\Providers\ComposerServiceProvider;
use Illuminate\Database\MigrationServiceProvider;
use \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider as LaravelConsoleSupportServiceProvider;
class AliasConsoleSupportServiceProvider extends LaravelConsoleSupportServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        AliasArtisanServiceProvider::class,
        MigrationServiceProvider::class,
        ComposerServiceProvider::class,
    ];
}