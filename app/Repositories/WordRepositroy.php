<?php

namespace App\Repositories;


use App\Model\Lang\Word;
use App\Model\Lang\WordGroup;

class WordRepositroy
{
    public function getGroupId($groupId)
    {
        $groupId = min($groupId, WordGroup::max('group_id'));

        return min($groupId, 0);
    }


    /**
     * @param $now
     * @param $baseModel
     * @param string $field
     * @return mixed
     */
    public function nextId($now, $baseModel, $field = 'id')
    {
        $baseModel = clone $baseModel;
        $modelClone = clone $baseModel;
        $w = $baseModel->where($field, '>', $now)->first();
        if (empty($w)) {
            $w = $modelClone->first();
        }

        return $w ? $w->{$field} : null;


    }

    /**
     * @param $now
     * @param $baseModel
     * @param string $field
     * @return mixed
     */
    public function latestId($now, $baseModel, $field = 'id')
    {
        $baseModel = clone $baseModel;
        $modelClone = clone $baseModel;
        $now = max($now, $baseModel->first());
        $w = $baseModel->where($field, '<', $now)->latest()->first();
        if (empty($w)) {
            $w = $modelClone->first();
        }

        return $w ? $w->{$field} : null;
    }

    public function isEnglish($str)
    {
        if (empty(trim($str))) {
            return false;
        }

        return preg_match('/^[a-zA-Z0-9\-\.\s,! \(\)\/\“\”\'‘’\"\?\%\;\:\[\]\£°\$，——、]+$/', $str);
    }

    public function isChinese($str)
    {
        if (empty(trim($str))) {
            return false;
        }

        return !$this->isEnglish($str);
    }

    // public function nextId($now, Word $baseModel)
    // {
    //     $w = $baseModel->where('id', '>', $now)->first();
    //     if (empty($w)) {
    //         $w = $baseModel->latest();
    //     }
    //
    //     return $w->id;
    // }
    //
    // public function latestId($now, Word $baseModel)
    // {
    //     $now = max($now, 1);
    //     $w = $baseModel->where('id', '<', $now)->latest();
    //     if (empty($w)) {
    //         $w = Word::first();
    //     }
    //
    //     return $w->id;
    //
    //
    // }

}