<?php

namespace App\Model\Lang\Diver;


interface WordInterface
{
    public function __construct($obj);


    public function getTranslateTexts();

    public function getPham();

    public function getAmAudio();

    public function sents();
}