<?php

namespace Util;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClientHelper
{
    static $debug = false;

    public function __construct($options = ['timeout' => 5.0,], $headers = null, $cookies = null)
    {
        // $cookieJar = CookieJar::fromArray([
            //     'shshshfpa'='485323f9-9e37-bc1f-4319-6bae032c11da-1510539925',
            // ], 'www.devkang.com');
        $this->decode = function ($data) {
            return json_decode($data, true);
        };
        $this->client = new Client(array_merge($options, ['cookies' => $cookies, 'headers' => $headers]));
    }

    public static function debug()
    {
        static::$debug = true;
    }

    public function request($method, $uri = '', array $options = [])
    {
        $newOptions= [];
        foreach ($options as $k=>$v){
            if (!empty($v)){
                $newOptions[$k]=$v;
            }
        }
        $response = $this->client->request($method, $uri, $newOptions);
        $content = $this->getContent($response);
        if (static::$debug) {
            file_put_contents(storage_path('req-' . date('YmdHis-') . uniqid() . ''), $content);
        }

        return $content;
    }

    public function get($uri, $query = [], $headers = [])
    {
        return $this->request('GET', $uri, [
            'query'   => $query,
            'headers' => $headers,
        ]);

    }


    public function delete($uri, $data = [], $query = [], $headers = [])
    {
        return $this->request('DELETE', $uri, [
            'form_params' => $data,
            'query'       => $query,
            'headers'     => $headers,

        ]);

    }

    public function put($uri, $data = [], $query = [], $headers = [])
    {
        return $this->request('PUT', $uri, [
            'form_params' => $data,
            'query'       => $query,
            'headers'     => $headers,

        ]);

    }

    public function post($uri, $data = [], $query = [], $headers = [])
    {
        return $this->request('POST', $uri, [
            'form_params' => $data,
            'query'       => $query,
            'headers'     => $headers,

        ]);


    }


    public function getApi($uri, $query=[], $headers = [])
    {
        return $this->decode($this->get($uri, $query, $headers));
    }


    public function deleteApi($uri, $data=[], $query = [], $headers = [])
    {
        return $this->decode($this->delete($uri, $data, $query, $headers));
    }

    public function putApi($uri, $data=[], $query = [], $headers = [])
    {
        return $this->decode($this->put($uri, $data, $query, $headers));
    }

    public function postApi($uri, $data=[], $query = [], $headers = [])
    {
        return $this->decode($this->post($uri, $data, $query, $headers));
    }


    public function setDecode($decode)
    {
        $this->decode = $decode;
    }

    protected function decode($content)
    {
        return call_user_func($this->decode, $content);
    }


    public function getContent(ResponseInterface $rs)
    {
        $encoding = null;
        $type = $rs->getHeader('content-type');
        if (isset($type[0])) {
            preg_match("/.*charset=(.*)/", $type[0], $matchs);
            if (isset($matchs[1])) {
                $encoding = trim($matchs[1], '"');
            }
        }
        $content = $rs->getBody()->getContents();
        if (!empty($encoding)) {
            $content = mb_convert_encoding($content, "UTF-8", $encoding);
        }

        return $content;
    }

}