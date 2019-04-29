<?php

namespace App\Model;

use App\Mailer\UserMailer;
use App\Model\Account\Account;
use App\Model\Account\AccountTransfer;
use App\Model\Answer;
use App\Model\Message;
use App\Model\Question;
use App\Model\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $confirmation_token
 * @property int $is_active
 * @property int $questions_count
 * @property int $answers_count
 * @property int $comments_count
 * @property int $favorites_count
 * @property int $likes_count
 * @property int $followers_count
 * @property int $followings_count
 * @property array $settings
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followersUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $follows
 * @property-read \App\Model\MessageCollection|\App\Model\Message[] $messages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFavoritesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFollowingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $account_id
 * @property int|null $frozen_account_id
 * @property int $type 1 普通用户 2 系统用户
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFrozenAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereType($value)
 * @property-read \App\Model\Account\Account $account
 * @property-read \App\Model\Account\Account $frozenAccount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User query()
 */
class User extends Authenticatable
{
    const USER_SYSTEM = 2;
    const USER_NORMAL = 1;
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'confirmation_token',
        'api_token',
        'settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * @return Setting
     */
    public function settings()
    {
        return new Setting($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id == $model->uid;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * @param $question
     * @return array
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    /**
     * @param $question
     * @return bool
     */
    public function followed($question)
    {
        return !!$this->follows()->where('question_id', $question)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * @param $user
     * @return array
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }

    /**
     * @param $answer
     * @return array
     */
    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    /**
     * @param $answer
     * @return bool
     */
    public function hasVotedFor($answer)
    {
        return !!$this->votes()->where('answer_id', $answer)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'to_uid');
    }

    /**
     * send password reset email to user's email base on token.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        (new UserMailer())->passwordReset($this->email, $token);
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function frozenAccount()
    {
        return $this->hasOne(Account::class, 'id', 'frozen_account_id');
    }

    public function transfers()
    {
        return AccountTransfer::whereFromUid($this->id)
                              ->orWhere('to_uid', $this->id)
                              ->orderByDesc('id')
                              ->get();

    }
}
