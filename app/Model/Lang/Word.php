<?php

namespace App\Model\Lang;

use App\Model\Lang\Diver\ShanbayWord;
use App\Model\Lang\Diver\SimpleWord;
use App\Model\Lang\Diver\YoudaoWord;
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
 * @property array|null $sent 例句id数组
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereSent($value)
 * @property array $example
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereExample($value)
 * @method getTranslateTexts()
 * @method getPham()
 * @method getAmAudio()
 * @method sents()
 * @method getFirstTranslateText()
 * @property $type youdao shanbay simple
 * @property string|null $simple_trans
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereSimpleTrans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereType($value)
 */
class Word extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'translate' => 'array',
        'sent'      => 'array',
        'example'   => 'array',
    ];

    protected $_diver = null;


    public function _diver()
    {
        if (empty($this->_diver)) {
            if ($this->type == 'youdao') {
                $this->_diver = new YoudaoWord($this);
            } elseif ($this->type == 'shanbay') {
                $this->_diver = new ShanbayWord($this);
            }elseif ($this->type == 'simple') {
                $this->_diver = new SimpleWord($this);
            }
        }

        return $this->_diver;
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, [
            'getFirstTranslateText',
            'getTranslateTexts',
            'getPham',
            'getAmAudio',
            'sents',
        ])) {
            return call_user_func_array([$this->_diver(), $name], $arguments);
        } else {
            return parent::__call($name, $arguments);
        }
    }


    public function firstSent()
    {
        $sents = $this->sents();

        return collect($sents)->first() ?: [];

    }

}
