<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Finance\StockLog
 *
 * @property int $id
 * @property int $stock_id
 * @property float $price
 * @property float $price_change
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog wherePriceChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float $market_value 市值
 * @property int $turnover 成交量
 * @property int $circulation 发行量
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereCirculation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereMarketValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereTurnover($value)
 * @property float|null $open_price 开盘价
 * @property float|null $close_price 收盘价
 * @property float|null $high_price 最高价
 * @property float|null $low_price 最低价
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereClosePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereHighPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereLowPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereOpenPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog query()
 */
class StockLog extends Model
{
    //
}
