<?php

namespace App\Model;

use App\Model\Answer;
use App\Model\Topic;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 *
 * @package App
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $uid
 * @property int $comments_count
 * @property int $followers_count
 * @property int $answers_count
 * @property string $close_comment
 * @property string $is_hidden
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Topic[] $topics
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCloseComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereUserId($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'body', 'uid'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Model\Comment', 'commentable');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }
}
