<?php

namespace App\PersistModel;


use Util\Persist\Persist;

/**
 * Class BookLearn
 * @package App\PersistModel
 * @property $now
 * @property $nowLearned
 */
class BookLearn extends Persist
{
    static $_table = 'BookLearn';

    //限定数据结构
    public function structure()
    {
        return [
            'now'        => 0,
            'nowLearned' => 0,
        ];
    }
}