<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_uid')->comment('转出人');
            $table->integer('to_uid')->comment('转入人');
            $table->integer('from_account_id')->comment('转出账户');
            $table->integer('to_account_id')->comment('转入账户');
            $table->string('biz_id',60)->comment('业务订单号');
            $table->tinyInteger('biz_type')->comment('业务类型 1 充值 2 转账 ');
            $table->string('title',10,2);
            $table->tinyInteger('status')->default(0)->comment('1 成功 2 失败 3 撤回 ');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->unique(['from_account_id','to_account_id', 'biz_type', 'biz_id'],'account_transfers_unique_from_and_to_and_biz');//一次转账必须唯一
            $table->index('from_uid');
            $table->index('to_uid');
            $table->index('from_account_id');
            $table->index('to_account_id');
            $table->index('biz_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transfers');
    }
}
