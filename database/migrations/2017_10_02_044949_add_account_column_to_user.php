<?php

use App\Model\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountColumnToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('account_id')->nullable();
            $table->integer('frozen_account_id')->nullable();
            $table->integer('type')->default(1)->comment('1 普通用户 2 系统用户');
            $table->index('account_id');
            $table->index('frozen_account_id');

        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->dropColumn('frozen_account_id');

        });
    }

    public function seed()
    {
       //创建初始账户
        $user = resolve(\App\Repositories\UserRepository::class)->create(
            new User([
                'name' => 'ccq18',
                'email' => '1677937163@qq.com',
                'avatar' => '/images/avatars/default.png',
                'password' => bcrypt('123456'),
                'api_token' => str_random(60),
                'settings' => ['city' => ''],
            ])
        );



    }
}
