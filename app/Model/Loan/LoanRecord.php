<?php

namespace App\Model\Loan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Loan\LoanRecord
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $loan_id
 * @property int $uid
 * @property float $money
 * @property float $scale
 * @property string|null $started_at 开始时间
 * @property string|null $ended_at 结束时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord query()
 */
class LoanRecord extends Model
{
    //
}
