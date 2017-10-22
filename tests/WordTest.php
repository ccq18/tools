<?php

namespace Tests;


class WordTest extends TestCase
{
    public function testTranslate()
    {
        dump(count(config('words')));
    }
}