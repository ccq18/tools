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
        return '';
    }

    /**
     * @return []
     */
    public function getTranslateTexts()
    {
        return [];
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
}