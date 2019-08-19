<?php

namespace Ido\Tools\ClassGenerator;


//Str::studly
use Illuminate\Support\Str;
//snake_snake
// Str::snake()
// Str::camel()

class GenerateHelper
{
    static function getClassName($fullClass){
        return basename(str_replace('\\','/',$fullClass));
    }

}