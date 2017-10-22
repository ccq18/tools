<?php

namespace App\Http\Controllers\Web;


class WordController
{
    public function index()
    {
        $words = config('words');
        $now = request('word_id');
        $k = 'word7000' . auth()->id();
        if (empty($now)) {
            $now = \Cache::get($k, 0);
        }
        $now = max(min($now,count($words)-1),0);
        $w = array_get($words, $now, []);
        $word = $w['translate'];

        $next = $now+1;
        $last = $now == 1 ? 1 : $now-1;



        \Cache::forever($k, $now);
        // dump($word);
        return view('words.index', compact('word', 'now', 'last', 'next'));
    }

    public function listWord()
    {

    }

}