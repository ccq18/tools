<?php

namespace App\Model\Lang\Diver;


interface WordInterface
{
    public function __construct($obj);

    /**
     * @return string
     */
    public function getFirstTranslateText();

    /**
     * @return []
     */
    public function getTranslateTexts();
    /**
     * @return string
     */
    public function getPham();
    /**
     * @return string
     */
    public function getAmAudio();
    /**
     * @return []
     */
    public function sents();
    /**
     * @return string
     */
    public function getUkAudio();
    /**
     * @return string
     */
    public function getFirstEnglishTran();
    /**
     * @return []
     */
    public function getEnglishTrans();

}