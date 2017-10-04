<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\AccountTransfer
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $from_uid 转出人
 * @property int $to_uid 转入人
 * @property int $from_account_id 转出账户
 * @property int $to_account_id 转入账户
 * @property string $biz_id 业务订单号
 * @property int $biz_type 业务类型
 * @property string $title
 * @property int $status 1 成功 2 失败 3 撤回
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereBizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereBizType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereFromAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereFromUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereToUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereUpdatedAt($value)
 */
class AccountTransfer extends Model
{
    /*1 成功 2 失败 3 撤回*/
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;
    const STATUS_CANCEL = 3;

    const BIZ_TYPE_RECHARGE = 1;
}
