<?php

namespace Util;


class Reflection
{

    /**
     * @param $class
     * @param string $prefix 前缀 对大小写不敏感
     * @return string[]
     */
    public static function getConstants($class, $prefix = null)
    {
        $or = new \ReflectionClass($class);
        $consts = $or->getConstants();
        if(is_null($prefix)){
            return $consts;
        }
        return collect($consts)->filter(function($v,$k)use($prefix){
            return strcasecmp(substr($k,0,strlen($prefix)) , $prefix ) === 0;
        })->all();

    }

}