<?php

namespace App\Spl;


use SplDoublyLinkedList;

class LinkListHelper
{
    public function getByPad($len, $base = [])
    {
        $doubly = new \SplDoublyLinkedList();

        foreach ($base as $v){
            $doubly->push($v);
        }
        for ($i = $doubly->count(); $i < $len; $i++) {
            $doubly->push(null);
        }

        return $doubly;
    }


    public function getArrAndNotNull($doubly)
    {
        $rs = [];
        foreach ($doubly as $k => $v) {
            if (!is_null($v)) {
                $rs[$k] = $v;
            }
        }

        return $rs;
    }

    public function getArr($doubly)
    {
        $rs = [];
        foreach ($doubly as $k => $v) {
            $rs[$k] = $v;
        }

        return $rs;
    }

    public function addOrReplace(SplDoublyLinkedList $doubly,$index,$v)
    {

        // if(is_null($doubly->offsetGet($index))){
        //     $doubly->offsetUnset($index);
        // }
        $doubly->add($index,$v);
        return $doubly;
    }

    public function findFirst(SplDoublyLinkedList $doubly,$find)
    {
        foreach ($doubly as $k => $v){
            if($find === $v){
                return $k;
            }
        }

    }

}