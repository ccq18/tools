<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Follow
 *
 * @package App
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Follow whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Follow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Follow whereUserId($value)
 * @mixin \Eloquent
 */
class Follow extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_question';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'question_id'];
}
