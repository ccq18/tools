<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    public function seed()
    {
        $user = User::create([
            'name' => 'ccq18',
            'email' => '348578429@qq.com',
            'avatar' => '/images/avatars/default.png',
            'confirmation_token' => str_random(40),
            'password' => bcrypt('123456'),
            'api_token' => str_random(60),
            'settings' => ['city' => ''],
        ]);

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();

    }
}
