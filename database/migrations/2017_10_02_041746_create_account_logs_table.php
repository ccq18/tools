<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->comment('账户');
            $table->integer('transfer_id')->nullable()->comment('转让记录id');
            $table->string('title')->comment('标题');
            $table->decimal('amount', 10, 2);
            $table->index('transfer_id');
            $table->index('account_id');
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
        Schema::dropIfExists('account_logs');
    }
}
