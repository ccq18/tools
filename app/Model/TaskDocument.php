<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\TaskDocument
 *
 * @property int $id
 * @property int $task_id
 * @property string $page_content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument wherePageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereType($value)
 * @property int $retry
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereRetry($value)
 */
class TaskDocument extends Model
{
    //
}
