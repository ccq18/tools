<?php

namespace App\Model\Lang\Diver;


class YoudaoWord implements WordInterface
{

    use ProxyTrait;



    public function getTranslateTexts()
    {
        $rs = [];
        if(!empty($this->translate['symbols'][0]['parts']))
        foreach ($this->translate['symbols'][0]['parts'] as $v) {
            $rs[] = $v['part'] . implode(' ', $v['means']);
        }

        return $rs;

    }

    public function getPham()
    {
        return isset($this->translate['symbols'][0]['ph_am']) ? $this->translate['symbols'][0]['ph_am'] : "";
    }

    public function getAmAudio()
    {
        return isset($this->translate['symbols'][0]['ph_am_mp3']) ? $this->translate['symbols'][0]['ph_am_mp3'] : "";
    }

    protected function getDetail()
    {
        $detail = str_translate($this->word, 'str_translate_diver_jinshan_detail');
        if (!empty($detail['sent'])) {
            foreach ($detail['sent'] as $k => $v) {
                $detail['sent'][$k]['orig'] = trim($v['orig']);
                $detail['sent'][$k]['trans'] = trim($v['trans']);
            }
        }

        return $detail;
    }



    public function sents()
    {
        $detail = $this->getDetail();

        return isset($detail['sent']) ? $detail['sent'] : [];

    }
}