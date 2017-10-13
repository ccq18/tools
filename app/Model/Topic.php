<?php

namespace App\Model;

use App\Model\Question;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string|null $bio
 * @property int $questions_count
 * @property int $followers_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $questions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'questions_count', 'bio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}