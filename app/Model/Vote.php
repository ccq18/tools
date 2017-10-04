<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $answer_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereUid($value)
 * @mixin \Eloquent
 */
class Vote extends Model
{
    //
}
