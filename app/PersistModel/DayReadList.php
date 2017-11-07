<?php

namespace App\PersistModel;


use Util\Persist\Persist;

class DayReadList extends Persist
{
    static $_table = 'DayReadList';

    public function addWord($id)
    {
        $nowKey = date('Y-m-d');

        if (!isset($this->items[$nowKey])) {
            $this->items[$nowKey] = [];
        }
        if (!in_array($id, $this->items[$nowKey])) {
            $this->items[$nowKey][] = $id;
        }
        $this->save();
    }
}