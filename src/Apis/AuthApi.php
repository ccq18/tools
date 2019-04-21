<?php

namespace Apis;


use App\Model\User;
use GuzzleHttp\Client;

class AuthApi
{
    protected $client = null;


    public function login($username, $password)
    {

        /**
         * @var User $user
         */
        $user = User::query()->where('username', $username)->find();
        if (empty($user)) {
            return null;
        }
        if (!$user->verify($password)) {
            return null;
        }

        return $user;

    }


    public function authSession($user)
    {
        if (empty($user)) {
            return false;
        }
        session('user', $user);

        return true;
    }

    public function getUserBySession()
    {
        return session('user');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function logoutBySession($request)
    {
        return session()->invalidate();
    }



}