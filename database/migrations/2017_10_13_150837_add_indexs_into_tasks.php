<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexsIntoTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //delete from tasks where  id not in (select id from (select id  from tasks group by hash) as tmp_task_ids)
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('hash',32)->comment('MD5(domain,task_url)');
        });
        \DB::update("update tasks set hash=md5(concat(domain,task_url))");
        Schema::table('tasks', function (Blueprint $table) {
            $table->unique(['hash'],'tasks_index_unique_hash');
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
            $table->dropIndex('tasks_index_unique_hash');
            $table->dropColumn('hash');
        });
    }
}
