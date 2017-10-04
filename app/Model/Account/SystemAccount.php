<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\SystemAccounts
 *
 * @property int $id
 * @property int $uid
 * @property int $account_id
 * @property int $type 1 充值账户
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereUid($value)
 * @mixin \Eloquent
 */
class SystemAccount extends Model
{
    const TYPE_RECHARGE = 1;
    //
    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
