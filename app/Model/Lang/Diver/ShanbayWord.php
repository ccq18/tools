<?php

namespace App\Model\Lang\Diver;


class ShanbayWord implements WordInterface
{
    use ProxyTrait;
    public function getFirstTranslateText()
    {
        $translates = $this->getTranslateTexts();
        return isset($translates[0])?$translates[0]:"";
    }
    public function getTranslateTexts()
    {
        return isset($this->translate['definition']) ? explode("\n", $this->translate['definition']):"";
    }

    public function getPham()
    {
        return isset($this->translate['definition']) ? $this->translate['pronunciation']:"";

    }

    public function getAmAudio()
    {
        return isset($this->translate['definition']) ? $this->translate['us_audio']:"";
    }


    public function sents()
    {
        //sys or other
        $sents = [];
        if (!empty($this->translate['definition'])) {

            foreach ($this->example['sys'] as $sent) {
                $sents[] = ['trans' => $sent['translation'], 'orig' => $sent['annotation']];
            }
        }

        return $sents;
    }
}