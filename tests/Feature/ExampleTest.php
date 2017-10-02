<?php

namespace Tests\Feature;

use App\Model\User;
use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Util\Reflection;

class Mcrypt
{

    public static function encrypt($code)
    {

        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(KEY), $code, MCRYPT_MODE_ECB,
            mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    public static function decrypt($code)
    {
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(KEY), base64_decode($code), MCRYPT_MODE_ECB,
            mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
    }

}

class ExampleTest extends TestCase
{
    public function test1()
    {
        $this->assertEquals(2, count(Reflection::getConstants(User::class, 'user')));
        $this->assertEquals(2, count(Reflection::getConstants(User::class, 'USER')));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // $response = $this->get('/');
        //
        // $response->assertStatus(200);
        $period = '300';
        $json = $this->getApi("http://api.huobi.com/staticmarket/btc_kline_{$period}_json.js?length=500");
//         001	1分钟线
// 005	5分钟
// 015	15分钟
// 030	30分钟
// 060	60分钟
// 100	日线
// 200	周线
// 300	月线
// 400	年线
        //时间  开盘价，最高价，最低价，收盘价，成交量
        collect($json)->map(function ($v) {
            echo substr($v[0], 0, 8) . "-{$v[2]}" . PHP_EOL;
        });
        // dump($json);


    }

    public function getApi($uri)
    {
        $client = new Client();

        $rs = $client->get($uri, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        return json_decode($rs->getBody()->getContents(), true);


    }

    public function testdetail()
    {
        $json = $this->getApi('http://api.huobi.com/staticmarket/detail_btc_json.js');
        var_dump($json);
    }

    public function teststaticmarket()
    {
        $json = $this->getApi('http://api.huobi.com/staticmarket/ticker_btc_json.js');
        // 报价：最高价，最低价，当前价，成交量，买1，卖1
        var_dump($json);
    }
}
