<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\JdProduct
 *
 * @property int $id
 * @property string $name
 * @property string $coupons
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereCoupons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct whereUrl($value)
 * @mixin \Eloquent
 * @property string $promos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JdProduct wherePromos($value)
 */
class JdProduct extends Model
{

}