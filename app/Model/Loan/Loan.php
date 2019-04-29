<?php

namespace App\Model\Loan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Loan\Loan
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $apr
 * @property string $title
 * @property string $content
 * @property int $uid
 * @property float $amount
 * @property int $loan_status
 * @property string|null $started_at 开始时间
 * @property string|null $ended_at 结束时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereApr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereLoanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan query()
 */
class Loan extends Model
{
    //
}
