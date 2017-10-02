<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGithubRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('repository_url');
            $table->string('repository_name');
            $table->string('author_url');
            $table->string('language');
            $table->text('remark');
            $table->tinyInteger('status');
            $table->integer('star');
            $table->integer('fork');
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
        Schema::dropIfExists('github_repositories');
    }
}
