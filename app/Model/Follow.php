<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Follow
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $question_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereUid($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow query()
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
    protected $fillable = ['uid', 'question_id'];
}
