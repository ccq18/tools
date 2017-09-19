<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * @package App
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $body
 * @property string $has_read
 * @property string|null $read_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $dialog_id
 * @property-read \App\User $fromUser
 * @property-read \App\User $toUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereDialogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereHasRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $fillable = ['from_user_id', 'to_user_id', 'body', 'dialog_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     *
     */
    public function markAsRead()
    {
        if(is_null($this->read_at)) {
            $this->forceFill(['has_read' => 'T','read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * @param array $models
     * @return MessageCollection
     */
    public function newCollection(array $models = [])
    {
        return new MessageCollection($models);
    }

    /**
     * @return bool
     */
    public function read()
    {
        return $this->has_read === 'T';
    }

    /**
     * @return bool
     */
    public function unread()
    {
        return $this->has_read === 'F';
    }

    /**
     * @return bool
     */
    public function shouldAddUnreadClass()
    {
        if(user()->id === $this->from_user_id) {
            return false;
        }
        return $this->unread();
    }
}
