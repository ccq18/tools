<?php

namespace App\Model\Loan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Loan\LoanRepaymentRecord
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property int $form_account_id
 * @property float $amount
 * @property string|null $real_payment_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereFormAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereRealPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord query()
 */
class LoanRepaymentRecord extends Model
{
    //
}
