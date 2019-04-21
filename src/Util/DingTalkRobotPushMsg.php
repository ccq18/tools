<?php

namespace Util;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class DingTalkRobotPushMsg
{
    /**
     * @var Client
     */
    protected $guzzle;
    protected $pushcode;

    public function __construct($pushcode)
    {
        $this->guzzle = new Client([
            RequestOptions::TIMEOUT => 30,
            'headers'               => ['Content-Type' => 'application/json'],
        ]);
        $this->pushcode = $pushcode;
    }

    public function push($msg)
    {
        $params = json_encode(['msgtype' => 'text', 'text' => ['content' => $msg]]);

        $data = $this->guzzle->postJson(config('dingTalk.robotPushMsg'), ['body' => $params]);

        return $this->response($data);
    }

    /**
     * @param  array $feedCards
     *
     * @return boolean
     */
    public function pushFeedCards($feedCards)
    {
        $params = json_encode(['msgtype' => 'feedCard', 'feedCard' => ['links' => $feedCards]]);

        $data = json_decode($this->guzzle->post($this->pushcode, ['body' => $params]),true);

        return $this->response($data);
    }

    protected function response($data)
    {

        if ($data->errcode != 0) {
            throw new \Exception($data->errmsg);
        }

        return $data;
    }

}