<?php

namespace App\Model\Lang;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Lang\Word
 *
 * @property int $id
 * @property int $book_id
 * @property int $number
 * @property string $word
 * @property string $base_str
 * @property array $translate
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereBaseStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereTranslate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereWord($value)
 * @mixin \Eloquent
 */
class Word extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'translate' => 'array'
    ];

    public function getFirstTranslate()
    {
        $s = '';
        $s.= isset($this->translate['symbols'][0]['parts'][0]['part'])?$this->translate['symbols'][0]['parts'][0]['part']:"";
        $s.= $this->getFirstTranslateText();
        return $s;
    }

    public function getFirstTranslateText()
    {
        return isset($this->translate['symbols'][0]['parts'][0]['means'][0])?$this->translate['symbols'][0]['parts'][0]['means'][0]:"";
    }
    public function getPham()
    {
     return isset($this->translate['symbols'][0]['ph_am'])?$this->translate['symbols'][0]['ph_am']:"";
    }
    public function getAudio()
    {
        return isset($this->translate['symbols'][0]['ph_am_mp3'])?$this->translate['symbols'][0]['ph_am_mp3']:"";
    }

    public function getDetail()
    {
        $detail = str_translate($this->word,'str_translate_diver_jinshan_detail');
        if(!empty($detail['sent'])){
            foreach ($detail['sent'] as $k => $v){
                $detail['sent'][$k]['orig'] = trim($v['orig']);
                $detail['sent'][$k]['trans'] = trim($v['trans']);
            }
        }

        return $detail;
    }

    public function lastSent()
    {
        $detail = $this->getDetail();
        return collect(isset($detail['sent'])?$detail['sent']:[])->last();

    }

    public function sents()
    {
        $detail = $this->getDetail();
        return isset($detail['sent'])?$detail['sent']:[];

    }
}
