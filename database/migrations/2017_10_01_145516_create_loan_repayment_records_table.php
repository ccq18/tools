<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRepaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayment_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->integer('form_account_id');
            $table->decimal('amount', 10, 2);
            $table->timestamp('real_payment_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_repayment_records');
    }
}
