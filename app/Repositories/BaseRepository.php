<?php

namespace App\Repositories;


use Util\Reflection;

class BaseRepository
{
    protected $bindClass = null;

    public function checkInConst($prefix, $v)
    {
        if (is_null($this->bindClass)) {
            throw new \Exception('请先绑定模型');
        }
        $consts = Reflection::getConstants($this->bindClass, $prefix);

        return in_array($v, $consts);
    }

}