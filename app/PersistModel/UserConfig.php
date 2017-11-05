<?php

namespace App\PersistModel;


use Util\Persist\Persist;

/**
 * Class UserConfig
 * @package App\PersistModel
 * @property $now
 * @property $example
 * @property $english_trans
 * @property $audio_num
 * @property $delay_time
 * @property $auto_jump
 */
class UserConfig extends Persist
{
    static $_table = 'UserConfig';


    //限定数据结构
    public function structure()
    {
        return [
            'now'           => 1,
            'example'       => 0,
            'english_trans' => 0,
            'audio_num'     => 0,
            'delay_time'    => 0,
            'auto_jump'     => 0,
        ];
    }
}