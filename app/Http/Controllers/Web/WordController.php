<?php

namespace App\Http\Controllers\Web;


use App\Model\Lang\Word;
use Carbon\Carbon;

class WordController
{
    const PAGE_SIZE = 12;

    public function index()
    {


        $isAuto = false;
        switch (request('action')) {
            case "last":
                $now = $this->getNow();
                $w = Word::where('book_id', 1)->where('id', '<', $now)->orderByDesc('id')->first();
                $now = $w->id;
                $this->cacheNow($now);
                break;
            case "next":
                $isAuto = true;
                $now = $this->getNow();
                $w = Word::where('book_id', 1)->where('id', '>', $now)->first();
                $now = $w->id;
                $this->cacheNow($now);
                break;
            default:
                $now = request('word_id');
                if (empty($now)) {
                    $now = $this->getNow();
                }
                $w = Word::where('book_id', 1)->where('id', '>=', $now)->first();
                $this->cacheNow($now);
                break;
        }
        $word = $w->translate;

        return view('words.index', compact('w', 'word', 'next', 'now', 'isAuto'));
    }

    protected function getNow($prefix = '', $default = 0)
    {
        $k = 'word7000' . $prefix . auth()->id();
        $data = \Cache::get($k, $default);

        return $data;
    }

    protected function cacheNow($data, $prefix = '')
    {
        $k = 'word7000' . $prefix . auth()->id();
        \Cache::forever($k, $data);

    }

    public function listWord()
    {
        $this->defaultOrPage();
        $words = Word::where('book_id', 1)->paginate(static::PAGE_SIZE);

        return view('words.list', ['words' => $words]);
    }

    protected function defaultOrPage()
    {
        $now = $this->getNow();
        $p = request('page');
        if (empty($p)) {
            $n = Word::where('book_id', 1)->where('id', '<', $now)->count();
            $p = floor($n / static::PAGE_SIZE + 1);

        } else {
            $n = Word::where('book_id', 1)->skip(($p - 1) * static::PAGE_SIZE)->first();
            $now = $n ? $n->id : Word::where('book_id', 1)->count();
        }
        // dump($now,$p);
        $this->cacheNow($now);
        \Request::merge(['page' => $p]);
    }

    protected function getNextWordId($increment)
    {
        $nowKey = date('Y-m-d');
        $lastKey = Carbon::yesterday()->format('Y-m-d');
        $readList = $this->getNow('word-data1',
            [
                'now'            => 0,
                'now-read-id'    => 1,
                'days'=>[],
            ]);
        $now = $readList['now'];
        $nowReadId = $readList['now-read-id'];
        $now += $increment;
        $now = max(0, $now);
        //初始化今日数据
        if (!isset($readList['days'][$nowKey])) {
            $today = [];
            $today['want-read-list'] = [];
            $today['read-list'] = [];
            $today['have-read-list'] = [];
            $today['today-study-list'] = [];
            $today['today-start-id'] = $nowReadId;
            //今日复习列表由昨日的复习列表决定
            if(isset($readList['days'][$lastKey]['read-list'])){
                $today['want-read-list'] = collect($readList['days'][$lastKey]['want-read-list'])->map(function($v)use($now){
                     $v['at'] -= $now;
                     return $v;
                })->all();
                //初始化基础数据
            }else if(empty($readList['now'])){
                $nowReadId = $this->getNow();
                $readeds = Word::where('book_id',1)->where('id','<', $nowReadId)->get();
                $today['want-read-list']  =  $readeds->map(function($vv){
                    $v['at'] = $vv->id*10+1000;
                    $v['increment'] = 256;
                    $v['id'] = $vv->id;
                    return $v;

                })->all();
            }

            $now = 0;
        }else{
            $today = $readList['days'][$nowKey];
        }

        if (count($today['read-list']) < $now) {
            $want = collect($today['want-read-list']);
            $wanted = $want->filter(function ($v) use ($now) {
                return $v['at'] <= $now;
            });
            $wanted->map(function ($v) use ($now) {
                $v['increment'] *= 4;
                $v['at'] = $now + $v['increment'];
                return $v;
            });
            $today['want-read-list'] = $want->filter(function ($v) use ($now) {
                return $v['at'] > $now;
            })->merge($wanted)->all();
            $today['read-list'] = array_merge($today['read-list'], $wanted->pluck('id')->all());
            $next = Word::where('book_id', 1)->where('id', '>', $nowReadId)->first();
            if (!empty($next)) {
                $nowReadId = $next->id;
                $today['want-read-list'][] = [
                    'increment' => 4,
                    'at'        => $now + 4,
                    'id'        => $nowReadId
                ];
                $today['read-list'][] = $nowReadId;
            }

        }
        $nextId =  isset($today['read-list'][$now])?$today['read-list'][$now]:$nowReadId;
        if($today['today-start-id'] <= $nextId && !in_array($nextId,$today['today-study-list'])){
            $today['today-study-list'][] = $nextId;
        }
        $today['have-read-list'][] = $nextId;


        $readList['now'] = $now;
        $readList['now-read-id'] = $nowReadId;
        $readList['days'][$nowKey] = $today;

        $this->cacheNow($readList, 'word-data1');

        return $nextId;
    }

    public function readWord()
    {
        $isAuto = false;
        switch (request('action')) {
            case "last":
                $nowId = $this->getNextWordId(-1);
                break;
            case "next":
                $isAuto = true;
                $nowId = $this->getNextWordId(1);

                break;
            default:
                $nowId = $this->getNextWordId(0);
                break;
        }
        $allNum = Word::where('book_id',1)->where('id','>', $nowId)->count();
        $nowNum = Word::where('book_id',1)->where('id','<=', $nowId)->count();
        $apr = number_format($nowNum / $allNum * 100, 2);
        $w = Word::where('id', '=', $nowId)->first();
        $word = $w->translate;

        return view('words.read-word', compact('w', 'word', 'next', 'now', 'isAuto', 'apr'));
    }


}