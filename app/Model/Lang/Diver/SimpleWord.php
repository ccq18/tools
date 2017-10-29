<?php

namespace App\Model\Lang\Diver;


class SimpleWord implements WordInterface
{
    use ProxyTrait;


    /**
     * @return string
     */
    public function getFirstTranslateText()
    {
        return $this->simple_trans;
    }

    /**
     * @return []
     */
    public function getTranslateTexts()
    {
        return [$this->simple_trans];
    }

    /**
     * @return string
     */
    public function getPham()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getAmAudio()
    {
        return '';
    }

    /**
     * @return []
     */
    public function sents()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getUkAudio()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getFirstEnglishTran()
    {
        return '';
    }

    /**
     * @return []
     */
    public function getEnglishTrans()
    {
        return [];
    }
}