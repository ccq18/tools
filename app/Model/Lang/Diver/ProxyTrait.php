<?php

namespace App\Model\Lang\Diver;


trait ProxyTrait
{
    public function __construct($obj)
    {
        $this->obj = $obj;

    }

    public function __call($name, $arguments)
    {
        return  call_user_func_array([$this->obj, $name], $arguments);
    }

    public function __get($name)
    {
        return $this->obj->{$name};
    }

}