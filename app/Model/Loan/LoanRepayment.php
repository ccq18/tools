<?php

namespace App\Model\Loan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Loan\LoanRepayment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $money
 * @property string|null $repayment_at
 * @property string|null $real_repayment_at
 * @property int $repayment_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRealRepaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRepaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRepaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment query()
 */
class LoanRepayment extends Model
{
    //
}
