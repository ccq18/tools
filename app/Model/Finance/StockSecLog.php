<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Finance\StockLog
 *
 * @property int $id
 * @property int $stock_id
 * @property int $stock_code
 * @property float $price
 * @property string $name
 * @property string $datetime
 * @property string $date
 * @property string $time
 * @property float $max
 * @property float $min
 * @property float $buy1_price
 * @property int $buy1_num
 * @property float $buy2_price
 * @property int $buy2_num
 * @property float $buy3_price
 * @property int $buy3_num
 * @property float $buy4_price
 * @property int $buy4_num
 * @property float $buy5_price
 * @property int $buy5_num
 * @property float $sell1_price
 * @property int $sell1_num
 * @property float $sell2_price
 * @property int $sell2_num
 * @property float $sell3_price
 * @property int $sell3_num
 * @property float $sell4_price
 * @property int $sell4_num
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy1Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy1Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy2Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy2Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy3Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy3Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy4Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy4Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy5Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereBuy5Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell1Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell1Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell2Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell2Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell3Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell3Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell4Num($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereSell4Price($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereStockCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockSecLog whereStockId($value)
 */
class StockSecLog extends Model
{
    protected $dates = ['datetime'];
}
