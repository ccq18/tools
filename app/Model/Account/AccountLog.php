<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\AccountLog
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $account_id 账户
 * @property int $transfer_id 转让记录
 * @property string $title 标题
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereUpdatedAt($value)
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereAmount($value)
 */
class AccountLog extends Model
{
    //
}
