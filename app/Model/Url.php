<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Url
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $type
 * @property int $uid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereUpdatedAt($value)
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereCode($value)
 * @property string|null $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Url query()
 */
class Url extends Model
{

    const TYPE_REDIRECT = 1;
    const TYPE_SHOW = 2;

    public function shortUrl()
    {
        return url('/u/' . $this->code);
    }
}