<?php

namespace App\Model\Lang\Diver;


class ShanbayWord implements WordInterface
{
    use ProxyTrait;

    public function getTranslateTexts()
    {
        return explode('\n', $this->translate['definition']);
    }

    public function getPham()
    {
        return $this->translate['pronunciation'];

    }

    public function getAmAudio()
    {
        return $this->translate['us_audio'];
    }


    public function sents()
    {
        $sents = [];
        //other
        foreach ($this->example['sys'] as $sent) {
            $sents[] = ['trans' => $sent['translation'], 'orig' => $sent['annotation']];
        }

        return $sents;
    }
}