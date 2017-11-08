<?php

namespace App\Repositories;


use App\Model\Lang\Word;
use App\Model\Lang\WordGroup;
use App\PersistModel\BookLearn;
use App\PersistModel\DayReadList;
use App\PersistModel\LearnInfo;
use App\PersistModel\NowReadList;
use App\PersistModel\ReadList;
use function PHPSTORM_META\map;

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

    /**
     * @param $wordIds
     * @param $max
     * @return 生成复习列表 array
     */
    public function getReviewListByIds($wordIds, $max)
    {

        $readList = [];
        $wantReadList = [];
        $now = 0;
        while (count($readList) < $max) {
            $now = max(0, $now);
            // $want = collect($wantReadList);
            $wanted = [];
            $want = [];
            foreach ($wantReadList as $v) {
                if ($v['increment'] > 1024) {
                    continue;
                }
                if ($v['at'] <= $now) {
                    $wanted[] = $v;
                } else {
                    $want[] = $v;
                }
            }
            $noWanted = array_slice($wanted, 5);
            $wanted = array_slice($wanted, 0, 5);
            $ids = [];
            foreach ($wanted as $k => $v) {
                $wanted[$k]['increment'] *= 4;
                $wanted[$k]['at'] = $now + $v['increment'];
                $ids[] = $v['id'];
            }

            $wantReadList = array_merge($want, $wanted, $noWanted);
            $readList = array_merge($readList, $ids);
            if (isset($wordIds[$now])) {
                $nowReadId = $wordIds[$now];
                $wantReadList[] = [
                    'increment' => 4,
                    'at'        => $now + 4,
                    'id'        => $nowReadId
                ];
                $readList[] = $nowReadId;
            }
            $now += 1;
            if (isset($wordIds[$now])) {
                $nowReadId = $wordIds[$now];
                $wantReadList[] = [
                    'increment' => 4,
                    'at'        => $now + 4,
                    'id'        => $nowReadId
                ];
                $readList[] = $nowReadId;
            }
            $now += 1;
        }


        return $readList;
    }

    public function generateReadListByRand($listIds)
    {
        $ids = $this->getReviewListByIds($listIds, count($listIds) * 3);

        return $this->generateList($ids, 'first_read', []);
    }

    public function getNext($i, $key, $allListIds)
    {
        $l = BookLearn::firstOrNew($key);
        $l->now += $i;
        $l->now  = max($l->now,0);
        $readList = ReadList::firstOrNew($key);
        //初始化
        if ($readList->date != date('Y-m-d')) {
            $readList->date = date('Y-m-d');
            if (count($allListIds) <= $l->nowLearnEd) {
                return null;
            }
            $oldIds = collect($readList->listId)->pluck('id')->unique()->values();

            $listIds = array_slice($allListIds, max($l->nowLearned - 2, 0), 200);
            $readList->listIds =  array_merge($this->generateList($oldIds, 'read_again', []),$this->generateReadListByGroup($listIds,2));
        }
        if (!isset($readList->listIds[$l->now])) {
            return null;
        }
        $l->nowLearned = max(array_search($readList->listIds[$l->now], $allListIds), $l->nowLearned);
        $l->save();
        $readList->save();

        return $readList->listIds[$l->now];

    }


    public function generateReadListByGroup($listIds,$multiple=2)
    {

        $num = 0;
        $readList = [];
        $start = 0;
        for ($i = 0; $i <= count($listIds); $i += 10) {
            $num++;
            //每学40个新词整个复习一次
            if ($num % 4 == 0) {
                $todayIds = collect($readList)->slice($start)->pluck('id')->unique()->values();
                $start = count($readList);
                $readList = $this->generateList($todayIds, 'read_again', $readList);
            }
            $ids = array_slice($listIds, $i, 10);
            $ids = $this->getReviewListByIds($ids, count($ids) * $multiple);
            $readList = $this->generateList($ids, 'first_read', $readList);
        }

        return $readList;
    }


    protected function generateList($ids, $type, $baseList=[])
    {
        foreach ($ids as $id) {
            $baseList[] = ['id' => $id, 'type' => $type];
        }

        return $baseList;
    }


}