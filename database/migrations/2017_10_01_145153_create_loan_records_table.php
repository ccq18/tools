<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id');
            $table->integer('uid');
            $table->decimal('money',10,2);
            $table->decimal('scale',10,5);
            $table->timestamp('started_at')->nullable()->comment('开始时间');
            $table->timestamp('ended_at')->nullable()->comment('结束时间');

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
        Schema::dropIfExists('loan_records');
    }
}
