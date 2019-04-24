<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Task
 *
 * @property int $id
 * @property string $domain
 * @property string $hash
 * @property string $task_url
 * @property string $type
 * @property string $extra
 * @property string $uniqueid
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereTaskUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $parse_status 解析状态 1 未解析 2 已解析
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereParseStatus($value)
 * @property-read \App\Model\TaskDocument $taskDocument
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereHash($value)
 */
class Task extends Model
{
    protected $casts = ['extra' => 'array'];

    const STATUS_INIT = 0;
    const STATUS_RUNNING = 2;
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 3;

    const PARSE_STATUS_INIT = 0;
    const PARSE_STATUS_RUNNING = 2;
    const PARSE_STATUS_SUCCESS = 1;
    const PARSE_STATUS_NONE = 3;

    // public function save(array $options = [])
    // {
    //     // $this->hash = md5($this->task_url . $this->type);
    //
    //     return parent::save($options);
    // }

    public static function add($domain, $taskUrl, $type,$hash, $extra = [])
    {
        if (Task::whereHash($hash)->whereDomain($domain)->first()) {
            return false;
        }

        $task = new Task();
        $task->domain = $domain;
        $task->extra = $extra;
        $task->hash = $hash;
        $task->task_url = $taskUrl;
        $task->type = $type;
        $task->status = 0;//0 未处理 1 已处理 2 处理中
        $task->parse_status = 0;//0 未处理 1 已处理 2 处理中
        try {
            $task->save();
        } catch (\Exception $e) {
        }


    }

    public function taskDocument()
    {
        return $this->hasOne(TaskDocument::class, 'task_id', 'id');

    }
}
