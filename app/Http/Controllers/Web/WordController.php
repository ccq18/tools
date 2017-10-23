<?php

namespace App\Http\Controllers\Web;


use App\Model\Lang\Word;

class WordController
{
    const PAGE_SIZE= 12;
    public function index()
    {
        // $words = require resource_path('data/words.php');//config('words');
        $now = request('word_id');
        $k = 'word7000' . auth()->id();
        if (empty($now)) {
            $now = \Cache::get($k, 0);
        }
        switch (request('action')) {
            case "last":
                $w = Word::where('id', '<', $now)->orderByDesc('id')->first();
                break;
            case "next":
                $w = Word::where('id', '>', $now)->first();
                break;
            default:
                $w = Word::where('id', '>=', $now)->first();
                break;
        }
        $now = $w->id;
        //array_get($words, $now, []);
        $word = $w->translate;
        \Cache::forever($k, $now);

        // dump($word);
        return view('words.index', compact('word', 'next', 'now'));
    }

    public function listWord()
    {
        $this->defaultOrPage();
        $words = Word::where('book_id', 1)->paginate(static::PAGE_SIZE);

        return view('words.list', ['words' => $words]);
    }

    protected function defaultOrPage()
    {
        $k = 'word7000' . auth()->id();
        $now = \Cache::get($k, 0);
        $p = request('page');
        if(empty($p)){
            $n = Word::where('book_id', 1)->where('id','<',$now)->count();
            $p = floor($n/static::PAGE_SIZE+1);

        }else{
            $n = Word::where('book_id', 1)->skip(($p - 1) * static::PAGE_SIZE)->first();
            $now = $n?$n->id:Word::where('book_id', 1)->count();
        }
        // dump($now,$p);
        \Cache::forever($k, $now);
        \Request::merge(['page' => $p]);
    }



}