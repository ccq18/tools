<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id');
            $table->decimal('price', 10, 2)->comment("价格");
            $table->decimal('price_change', 10, 2)->comment("价格变化");
            $table->decimal('market_value', 16, 2)->comment("市值");
            $table->integer('turnover')->comment("成交量");
            $table->integer('circulation')->comment("发行量");
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
        Schema::dropIfExists('stock_logs');
    }
}
