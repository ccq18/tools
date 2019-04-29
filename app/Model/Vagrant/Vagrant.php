<?php

namespace App\Model\Vagrant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Vagrant\Vagrant
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $status 状态 1已创建 2 已停止 3 运行中
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereTemplatePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $vagrant_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereVagrantFile($value)
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant query()
 */
class Vagrant extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_STOPPED = 2;
    const STATUS_RUNNING = 3;

    const BASE_PATH = '/Users/mac/phpcode/service/data/datas';
    use SoftDeletes;

    //
}
