<?php

namespace App\Model\Lang;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Lang\WordGroup
 *
 * @property int $id
 * @property int $list_id
 * @property int $unit_id
 * @property int $word_id
 * @property int $group_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\WordGroup whereWordId($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Lang\Word $word
 */
class WordGroup extends Model
{
    //

    public function word()
    {
        return $this->hasOne(Word::class, 'id', 'word_id');

    }

}
