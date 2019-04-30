<?php

namespace App\Console\Commands;


use App\Model\Task;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TaskHelper extends Command
{
    protected $signature = 'task {type}';

    public function handle()
    {
        $type = $this->argument('type');
        if ($type == 'init') {

            Task::whereStatus(Task::STATUS_RUNNING)->update(
                ['status' => Task::STATUS_INIT]
            );
            $this->info($type . ' success');
        }
        if ($type == 'retry') {
            Task::query()->update(
                ['status' => Task::STATUS_INIT]
            );
            $this->info($type . ' success');
        }
        $link = 'http://125.109.195.169';
        // $ip = '125.109.195.168:38124';
        if ($type == 'gvpn') {
            $arr = Array(3=>'a', 2=>'b');$rndKey = array_rand($arr);echo $arr[$rndKey];
            // $client = new Client(
            //     // ['proxy' => $ip]
            // );
            // $rs = $client->get($link);//->getBody();//->getContents();
            // var_dump(json_decode($rs, true));
        }
        // if ($type == 'vpn') {
        //
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $link);//要访问的url
        //     curl_setopt($ch, CURLOPT_PROXY, $ip);//使用代理访问 $ip是 ip:port 格式
        //     curl_setopt($ch, CURLOPT_USERAGENT,
        //         'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/3.0.0.13');//有的网站需要ua，设置一下
        //     curl_setopt($ch, CURLOPT_HEADER, 0);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https网站取消ssl验证
        //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//允许30*跳转
        //     curl_setopt($ch, CURLOPT_TIMEOUT, 30);//设置超时时间
        //     $response = curl_exec($ch);
        //     if ($response === false) {
        //         $error_info = curl_error($ch);
        //         curl_close($ch);//关闭curl
        //         var_dump($error_info);
        //     } else {
        //         curl_close($ch);//关闭curl
        //         var_dump(json_decode($response, true));
        //     }
        // }

    }

}