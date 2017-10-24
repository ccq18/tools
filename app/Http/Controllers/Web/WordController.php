<?php

namespace App\Http\Controllers\Web;


use App\Model\Lang\Word;
use App\Spl\LinkListHelper;

class WordController
{
    const PAGE_SIZE = 12;

    public function index()
    {


        $isAuto = false;
        switch (request('action')) {
            case "last":
                $now = $this->getNow();
                $w = Word::where('id', '<', $now)->orderByDesc('id')->first();
                $now = $w->id;
                $this->cacheNow($now);
                break;
            case "next":
                $isAuto = true;
                $now = $this->getNow();
                $w = Word::where('id', '>', $now)->first();
                $now = $w->id;
                $this->cacheNow($now);
                break;
            default:
                $now = request('word_id');
                if(empty($now)){
                    $now = $this->getNow();
                }
                $w = Word::where('id', '>=', $now)->first();
                $this->cacheNow($now);
                break;
        }
        $word = $w->translate;

        // dump($word);
        return view('words.index', compact('w','word', 'next', 'now', 'isAuto'));
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


    public function readWord()
    {
        $pushList = $this->getNow('read-list');
        if (empty($pushList)) {
            $n = $this->getNow();
            $words = Word::where('book_id', 1)->where('id','>',$n)->get();
            $readWordIds = $words->map(function ($v) {
                return $v->id;
            });
            $linkHelper = new LinkListHelper();
            $doubly = $linkHelper->getByPad($readWordIds->count() * 6, $readWordIds->all());
            foreach ($readWordIds->all() as $k => $id) {
                $first = $linkHelper->findFirst($doubly,function ($v)use($id){
                    return $id == $v;
                });
                $linkHelper->addOrReplace($doubly,$first + 4, $id);
                $linkHelper->addOrReplace($doubly,$first + 8, $id);
                $linkHelper->addOrReplace($doubly,$first + 16, $id);
                $linkHelper->addOrReplace($doubly,$first + 32, $id);
                $linkHelper->addOrReplace($doubly,$first + 64, $id);
                $linkHelper->addOrReplace($doubly,$first + 256, $id);
                $linkHelper->addOrReplace($doubly,$first + 1024, $id);

            }
            $this->cacheNow(0, 'read-now');
            $this->cacheNow(array_values($linkHelper->getArrAndNotNull($doubly)), 'read-list');
        }
        $now = $this->getNow('read-now');
        $readList = $this->getNow('read-list');
        $isAuto = false;

        switch (request('action')) {
            case "last":
                $now--;

                break;
            case "next":
                $isAuto = true;
                $now++;

                break;
            default:
                break;
        }
        $maxNum = count($readList) - 1;
        $apr = number_format($now/$maxNum*100,2);
        $now = max(min($maxNum, $now), 0);
        $this->cacheNow($now, 'read-now');
        $nowId = $readList[$now];
        $w = Word::where('id', '=', $nowId)->first();
        $word = $w->translate;

        return view('words.read-word', compact('w','word', 'next', 'now', 'isAuto','apr'));
    }


}