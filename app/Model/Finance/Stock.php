<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Finance\Stock
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $unit 计价单位 美元 人民币
 * @property int $type 类型 1 A股 2 深圳 3 美股 4 港股  5 比特币
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stock extends Model
{
    const TYPE_SH = 1;
    const TYPE_SZ = 2;

    //
}
