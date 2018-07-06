<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockSecLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sec_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('price');
            $table->timestamp('datetime');
            $table->string('date',10);
            $table->string('time',10);
            $table->decimal('max',10,5);
            $table->decimal('min',10,5);
            $table->decimal('buy1_price',10,5);
            $table->integer('buy1_num');
            $table->decimal('buy2_price',10,5);
            $table->integer('buy2_num');
            $table->decimal('buy3_price',10,5);
            $table->integer('buy3_num');
            $table->decimal('buy4_price',10,5);
            $table->integer('buy4_num');
            $table->decimal('buy5_price',10,5);
            $table->integer('buy5_num');

            $table->decimal('sell1_price',10,5);
            $table->integer('sell1_num');
            $table->decimal('sell2_price',10,5);
            $table->integer('sell2_num');
            $table->decimal('sell3_price',10,5);
            $table->integer('sell3_num');
            $table->decimal('sell4_price',10,5);
            $table->integer('sell4_num');
            $table->decimal('sell5_price',10,5);
            $table->integer('sell5_num');
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
        Schema::dropIfExists('stock_sec_logs');
    }
}
