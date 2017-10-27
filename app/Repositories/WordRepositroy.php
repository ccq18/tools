<?php

namespace App\Repositories;


use App\Model\Lang\Word;
use App\Model\Lang\WordGroup;

class WordRepositroy
{
    public function getGroupId($groupId)
    {
        $groupId = min($groupId,WordGroup::max('group_id'));
        return min($groupId,0);
    }

    public function nextId($now,Word $baseModel)
    {
            $w = $baseModel->where('id', '>', $now)->first();
            if(empty($w)){
                $w = $baseModel->latest();
            }
            return $w->id;


    }
    public function latestId($now,Word $baseModel)
    {
            $now = max($now, 1);
            $w = $baseModel->where('id', '<', $now)->latest();
            if (empty($w)) {
                $w = Word::first();
            }
            return $w->id;



    }

}