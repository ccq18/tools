<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPricesIntoStockLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_logs', function (Blueprint $table) {
            //open_price  close_price high_price low_price change turnover
            //开盘价	收盘价	最高价	最低价	成交量	涨跌幅
//8196930594,
            $table->decimal('open_price', 10, 2)->nullable()->comment("开盘价");
            $table->decimal('close_price', 10, 2)->nullable()->comment("收盘价");
            $table->decimal('high_price', 10, 2)->nullable()->comment("最高价");
            $table->decimal('low_price', 10, 2)->nullable()->comment("最低价");
            $table->decimal('price', 10, 2)->nullable()->comment("价格")->change();;
            $table->decimal('price_change', 10, 2)->nullable()->comment("价格变化")->change();;
            $table->decimal('market_value', 16, 2)->nullable()->comment("市值")->change();;
            $table->decimal('turnover',16,0)->nullable()->comment("成交量")->change();;
            $table->decimal('circulation',16,0)->nullable()->comment("发行量")->change();;
            $table->index('stock_id', 'stock_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_logs', function (Blueprint $table) {
            $table->dropColumn('open_price');
            $table->dropColumn('close_price');
            $table->dropColumn('high_price');
            $table->dropColumn('low_price');
            $table->dropIndex('stock_id');

        });
    }
}
