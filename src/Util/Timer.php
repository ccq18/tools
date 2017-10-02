<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/8/24
 * Time: 11:17
 */

namespace Util;


class Timer
{
    protected static $record = [];
    protected static $start;
    protected static $now;

    public static function start()
    {
        self::$start = microtime(true);
        self::$now = microtime(true);
    }

    public static function record($title = '')
    {
        $now = microtime(true);
        self::$record[] = ['use_time' => round($now - self::$now,5) * 1000, 'all_time' => round(($now - self::$start) * 1000,5), 'title' => $title ?: count(self::$record)];
        self::$now = microtime(true);
    }

    public static function show()
    {
        $s = '';
        foreach (self::$record as $k => $v) {
            $s .= PHP_EOL."{$v['title']}: use_time: {$v['use_time']}ms all_time{$v['all_time']}ms";
        }
        return $s;
    }
}