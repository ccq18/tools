<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\Account
 *
 * @mixin \Eloquent
 * @property int $id
 * @property float $uid
 * @property float $type 1 可用余额 2 冻结金额
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereUpdatedAt($value)
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereTitle($value)
 */
class Account extends Model
{
    const ACCOUNT_AMOUNT = 1;
    const ACCOUNT_FROZEN = 2;
    const ACCOUNT_SYSTEM = 3;

    const TYPE_RECHARGE = 1;
    const TYPE_TRANSFER = 2;



}
