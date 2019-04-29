<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Article
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article query()
 */
class Article extends Model
{
    //
}
