<?php

namespace App\Model;

use App\Model\Question;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $question_id
 * @property string $body
 * @property int $votes_count
 * @property int $comments_count
 * @property string $is_hidden
 * @property string $close_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Comment[] $comments
 * @property-read \App\Model\Question $question
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCloseComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereVotesCount($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer query()
 */
class Answer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uid', 'question_id', 'body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }
}
