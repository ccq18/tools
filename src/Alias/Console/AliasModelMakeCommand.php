<?php

namespace Alias\Console;


use Illuminate\Foundation\Console\ModelMakeCommand;

class AliasModelMakeCommand extends ModelMakeCommand
{

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace."\\Model";
    }
}