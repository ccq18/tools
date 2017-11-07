<?php

namespace Util\Persist;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Util\Fluent;


abstract class Persist extends Fluent
{
    /**
     * @var Persist[]
     */
    static $_objs = [];
    static $_table = null;
    protected $_key = null;
    protected $_baseitems = null;
    static $_prefix = 'persist';

    public static function redis()
    {
        return Redis::connection();
    }

    public static function saveAll()
    {
        foreach (Persist::$_objs as $v) {
            $v->save();
        }
    }

    public function __construct($key = null, $items = [], $persisted = false, $autoSave = true)
    {


        parent::__construct($this->init($items));
        $this->_key = $key;
        if ($persisted) {
            $this->_baseitems = $items;
        }
        if ($autoSave) {
            static::$_objs[] = $this;
        }
    }


    protected function init($items)
    {
        $structure = $this->structure();
        return array_merge($structure, $items);
    }


    //返回基本表结构 方便重构
    public function structure()
    {
        return [];
    }

    /**
     * @param $key
     * @return null|static
     */
    public static function find($key)
    {
        $v = static::redis()->hget(static::getPersistKey(), $key);
        if (empty($v)) {
            return null;
        }

        return static::getObj($key, $v, true);
    }

    public static function getNow()
    {
        return static::firstOrNew(auth()->id());
    }
    public static function firstOrNew($key)
    {
        $v = static::find($key);
        if (empty($v)) {
            $v = new static($key);
        }

        return $v;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function findAll()
    {
        $rs = collect();

        $data = static::redis()->hgetall(static::getPersistKey());
        if (empty($data)) {
            return $rs;
        }
        foreach ($data as $k => $v) {
            $rs->push(static::getObj($k, $v, true));
        }

        return $rs;
    }

    public static function getObj($k, $data, $persisted)
    {
        return new static($k, json_decode($data, true), $persisted);
    }

    public static function getPersistKey()
    {
        return static::$_prefix . ':' . static::$_table;
    }



    public function save()
    {
        if (empty($this->_key)) {
            throw new \Exception('key not exist');
        }
        if (empty(static::$_table)) {
            throw new \Exception('table not exist');
        }
        //若数据无变化则不存储
        if (json_encode($this->items) == json_encode($this->_baseitems)) {
            return;
        }
        static::redis()->hset($this->getPersistKey(), $this->_key, json_encode($this->items));
        $this->_baseitems = $this->items;
    }

}