<?php

namespace App\Model\Lang\Diver;


class ShanbayWord implements WordInterface
{
    use ProxyTrait;

    public function getFirstTranslateText()
    {
        $translates = $this->getTranslateTexts();

        return isset($translates[0]) ? $translates[0] : "";
    }

    public function getTranslateTexts()
    {
        return isset($this->translate['definition']) ? explode("\n", $this->translate['definition']) : "";
    }

    public function getPham()
    {
        return isset($this->translate['pronunciation']) ? $this->translate['pronunciation'] : "";

    }

    public function getAmAudio()
    {
        return isset($this->translate['definition']) ? $this->translate['us_audio'] : "";
    }

    public function getUkAudio()
    {
        return isset($this->translate['audio_addresses']['uk'][0]) ? $this->translate['audio_addresses']['uk'][0] : "";
    }

    public function sents()
    {
        //sys or other
        $sents = [];
        if (!empty($this->example['sys'])) {
            foreach ($this->example['sys'] as $sent) {
                $nowSent = ['trans' => $sent['translation'], 'orig' => $sent['annotation']];
                if (isset($sent['audio_addresses']['us'][0])) {
                    $nowSent['us_audio'] = $sent['audio_addresses']['us'][0];
                }
                if (isset($sent['audio_addresses']['us'][0])) {
                    $nowSent['uk_audio'] = $sent['audio_addresses']['uk'][0];
                }
                $sents[] = $nowSent;
            }
        }

        return $sents;
    }

    public function getFirstEnglishTran()
    {
        $translates = $this->getEnglishTrans();

        return isset($translates[0]) ? $translates[0] : "";
    }

    public function getEnglishTrans()
    {
        $rs = [];

        $allTrans = isset($this->translate['en_definitions']) ? $this->translate['en_definitions'] : [];

        foreach ($allTrans as $k=>$tran){
            $rs[] =  $k.'. '.implode(' ',$tran);
        }

        return $rs;

    }

}