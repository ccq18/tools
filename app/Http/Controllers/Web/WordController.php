<?php

namespace App\Http\Controllers\Web;


use App\Model\Lang\Word;

class WordController
{
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
                $w = Word::where('id', '<', $now)->first();
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
        $words = Word::where('book_id',1)->paginate(25);
        return view('words.list',['words'=>$words]);
    }

}