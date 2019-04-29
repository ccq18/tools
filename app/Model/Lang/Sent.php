<?php

namespace App\Model\Lang;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Lang\Sent
 *
 * @property int $id
 * @property string $orig 句子
 * @property string $trans 翻译
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereOrig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereTrans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent query()
 */
class Sent extends Model
{
    //
}
