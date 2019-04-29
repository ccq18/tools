<?php

namespace App\Model;


use App\Model\Account\Account;

/**
 * Class SystemUser
 *
 * @package App\Model
 * @property-read \App\Model\Account\Account[] $accounts
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
 * @property int|null $account_id
 * @property int|null $frozen_account_id
 * @property int $type 1 普通用户 2 系统用户
 * @property-read \App\Model\Account\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followersUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $follows
 * @property-read \App\Model\Account\Account $frozenAccount
 * @property-read \App\Model\MessageCollection|\App\Model\Message[] $messages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFavoritesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFollowingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFrozenAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser query()
 */
class SystemUser extends User
{
    const SYSTEM_UID = 10;
    public function accounts()
    {
        return $this->hasMany(Account::class, 'uid', 'id');
    }

}