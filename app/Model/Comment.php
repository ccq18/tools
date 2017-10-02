<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property string $body
 * @property int $commentable_id
 * @property string $commentable_type
 * @property int|null $parent_id
 * @property int $level
 * @property string $is_hidden
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $fillable = ['uid', 'body', 'commentable_id', 'commentable_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
