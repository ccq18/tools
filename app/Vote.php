<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote
 *
 * @package App
 * @property int $id
 * @property int $user_id
 * @property int $answer_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUserId($value)
 * @mixin \Eloquent
 */
class Vote extends Model
{
    //
}
