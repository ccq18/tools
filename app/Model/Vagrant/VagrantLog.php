<?php

namespace App\Model\Vagrant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Vagrant\VagrantLog
 *
 * @property int $id
 * @property string $vagrant_id
 * @property string $content
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereVagrantId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog query()
 */
class VagrantLog extends Model
{
    //
}
