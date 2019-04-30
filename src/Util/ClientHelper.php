<?php

namespace Util;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClientHelper
{
    static $debug = false;
    protected $response;
    protected $useProxy = false;

    public function __construct($options = ['timeout' => 5.0,], $headers = null, $cookies = null,$useProxy=false)
    {
        $this->useProxy = $useProxy;
        // $cookieJar = CookieJar::fromArray([
        //     'shshshfpa'='485323f9-9e37-bc1f-4319-6bae032c11da-1510539925',
        // ], 'www.devkang.com');
        $this->decode = function ($data) {
            return json_decode($data, true);
        };

        // ; //ip:port ip代理池
        $this->client = new Client(array_merge($options, [
            'cookies' => $cookies,
            'headers' => $headers,
        ]));
    }

    public function getProxy()
    {

// 无当前可用ip或者过期
// 获取代理池列表
// 遍历请求ip
// 成功加入可用代理池
// 无可用ip则报错
        $successIps = \Cache::get('successips');
        if (empty($successIps)) {
            //从ip池取得一组ip
            $vpnurl = 'http://piping.mogumiao.com/proxy/api/get_ip_al?appKey=25bd6426a1c546878186ae1810047ef2&count=20&expiryDate=0&format=1&newLine=2';
            $client = new Client(['timeout'=>3]);
            $rs = $client->get($vpnurl)->getBody()->getContents();
            $rs = json_decode($rs, true);
            $ips = $rs['msg'];
            $successIps = [];
            foreach ($ips as $ip) {
                try {

                    $link = 'http://service.issue.pw/api/ip';
                    $client = new Client(['proxy' => "{$ip['ip']}:{$ip['port']}",'timeout'=>3]);
                    $rs = $client->get($link)->getBody()->getContents();
                    $rs = json_decode($rs, true);
                    if ($rs['REMOTE_ADDR'] == $ip['ip']) {
                        $successIps[] = $ip;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            \Cache::forever('successips', $successIps);
        }

        if (empty($successIps)) {
            throw new \DomainException("无可用代理ip");
        }
        $ip = $successIps[array_rand($successIps)];
        return "{$ip['ip']}:{$ip['port']}";


    }

    public function removeIp($proxyip)
    {
        $successIps = \Cache::get('successips');
        foreach ($successIps as $key => $ip) {
            if ("{$ip['ip']}:{$ip['port']}" == $proxyip) {
                unset($successIps[$key]);
            }
        }
        \Cache::forever('successips', $successIps);
    }

    public static function debug()
    {
        static::$debug = true;
    }

    public function request($method, $uri = '', array $options = [])
    {
        $newOptions = [];
        foreach ($options as $k => $v) {
            if (!empty($v)) {
                $newOptions[$k] = $v;
            }
        }
        if ($this->useProxy) {
// 获取一个可用ip
// 请求
// 如果请求失败则移出可用ip，
// 并再获取一个，
// 重试一次
// 失败则移出 返回报错
            try {
                $newOptions['proxy'] = $this->getProxy();
                $response = $this->client->request($method, $uri, $newOptions);
            } catch (\Exception $e) {
                //remove ip
                $this->removeIp($newOptions['proxy']);
                $newOptions['proxy'] = $this->getProxy();
                try {
                    $response = $this->client->request($method, $uri, $newOptions);
                } catch (\Exception $e) {
                    $this->removeIp($newOptions['proxy']);
                    throw new \DomainException("请求异常");
                }
            }
        } else {
            $response = $this->client->request($method, $uri, $newOptions);
        }

        $this->response = $response;
        $content = $this->getContent($response);
        if (static::$debug) {
            $newOptionStr = var_export($newOptions, true);
            $logs = "method:\n {$method}\n uri:\n {$uri}\n newOptions:\n {$newOptionStr}\n content:\n{$content}\n";
            file_put_contents(storage_path('logs/req-' . date('YmdHis-') . uniqid() . ''), $logs);
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


    public function getApi($uri, $query = [], $headers = [])
    {
        return $this->decode($this->get($uri, $query, $headers));
    }


    public function deleteApi($uri, $data = [], $query = [], $headers = [])
    {
        return $this->decode($this->delete($uri, $data, $query, $headers));
    }

    public function putApi($uri, $data = [], $query = [], $headers = [])
    {
        return $this->decode($this->put($uri, $data, $query, $headers));
    }

    public function postApi($uri, $data = [], $query = [], $headers = [])
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