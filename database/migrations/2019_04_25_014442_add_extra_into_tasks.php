<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraIntoTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('extra');
            $table->string('domain',50)->change();
            $table->dropIndex('tasks_index_unique_hash');
            $table->unique(['domain','hash'],'tasks_domain_hash_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('extra');
            $table->dropIndex('tasks_domain_hash_unique');
            $table->unique(['hash'],'tasks_index_unique_hash');
        });
    }
}
