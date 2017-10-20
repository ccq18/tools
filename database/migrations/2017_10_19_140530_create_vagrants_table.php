<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVagrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vagrants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60);
            $table->string('path');
            $table->text('vagrant_file');
            $table->tinyInteger('status')->comment('状态 1已创建 2 已停止 3 已启动');
            $table->softDeletes();
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
        Schema::dropIfExists('vagrants');
    }
}
