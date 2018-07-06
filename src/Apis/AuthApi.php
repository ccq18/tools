<?php

namespace Apis;


use GuzzleHttp\Client;

class AuthApi
{
    protected $client = null;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('auth_server'),

            'timeout' => 5.0,
        ]);
    }

    public function authUser($username, $password)
    {

    }
}