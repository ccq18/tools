<?php
namespace Util\Word;


class WordRelation
{
    protected $wordList;
    protected $links = [];

    public function __construct($wordLists)
    {
        $this->wordList = $wordLists;
        foreach ($wordLists as $k => $words) {
            foreach ($words as $word) {
                $this->links[$word] = $k;
            }
        }
    }

    public function search($word)
    {
        if (!isset($this->links[$word])) {
            return [];
        }

        return $this->links[$word];
    }
}