<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/4/21
 * Time: 11:46
 */

namespace Util;


class Token
{
    protected $key;

    public function __construct($key = 'helloworldtoken')
    {
        $this->key = $key;
    }

    public function encode($id)
    {
        $time = time();
        $data = json_encode(['id' => $id, 'time' => $time]);
        $base64encode = base64_encode($data);
        $hash = md5($base64encode . $this->key);
        $token = $hash . '|' . $base64encode;

        return $token;
    }

    /**
     * @param $token
     * @return bool|['id'=>$id,'time'=>$time]
     */
    public function decode($token)
    {
        $fields = explode("|", $token);
        if (count($fields) != 2) {
            return false;
        }
        $hash = md5($fields[1] . $this->key);
        // 校验签名
        if ($hash != $fields[0]) {
            return false;
        }

        return json_decode(base64_decode($fields[1]), true);
    }


}