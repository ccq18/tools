<?php

namespace App\PersistModel;


use Util\Persist\Persist;

/**
 * Class LearnInfo
 * @package App\PersistModel
 * @property $now
 * @property $nowId
 * @property $nowAddedId
 * @property $date
 * @property $dayStartId
 */
class LearnInfo extends Persist
{
    static $_table = 'LearnedInfo';

    //限定数据结构
    public function structure()
    {
        return [
            'now'        => 0,
            'nowId'      => 0,
            'nowAddedId' => 0,
            'nowWord'    => [],
            'learns' =>[
            ]
        ];
    }

}