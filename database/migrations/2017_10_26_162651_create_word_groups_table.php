<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('list_id');
            $table->integer('unit_id');

            $table->integer('group_id');
            $table->integer('word_id');
            $table->index('group_id');
            $table->index('list_id');
            $table->index('unit_id');
            $table->index('word_id');

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
        Schema::dropIfExists('word_groups');
    }
}
