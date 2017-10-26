<?php

namespace Word;


class ListGenerate
{
    public function generateByWords($wordIds,$max)
    {

        $today = [
            'now'            => 0,
            'now-read-id'    => 1,
        ];
        $nowReadId = $today['now-read-id'];
        $today['want-read-list'] = [];
        $today['read-list'] = [];
        $today['have-read-list'] = [];
        $today['today-study-list'] = [];
        $today['today-start-id'] = $nowReadId;
        $now = $today['now'];
        while(count($today['read-list'])<$max){

            $now += 1;
            $now = max(0, $now);
            $want = collect($today['want-read-list']);
            $wanted = $want->filter(function ($v) use ($now) {
                return $v['at'] <= $now;
            });
            $noWanted = $wanted->slice(5);
            $wanted = $wanted->slice(0,5);
            $wanted = $wanted->map(function ($v) use ($now) {
                $v['increment'] *= 4;
                $v['at'] = $now + $v['increment'];
                return $v;
            });
            $today['want-read-list'] = $want->filter(function ($v) use ($now) {
                return $v['at'] > $now;
            })->merge($wanted)->merge($noWanted)->all();
            $today['read-list'] = array_merge($today['read-list'], $wanted->pluck('id')->all());
            $next = Word::where('book_id', 1)->where('id', '>', $nowReadId)->first();
            if (!empty($next)) {
                $nowReadId = $next->id;
                $today['want-read-list'][] = [
                    'increment' => 4,
                    'at'        => $now + 8,
                    'id'        => $nowReadId
                ];
                $today['read-list'][] = $nowReadId;
            }



        }


        return $nextId;
    }
}