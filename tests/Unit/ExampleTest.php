<?php

namespace Tests\Unit;

use App\Model\TaskDocument;
use Carbon\Carbon;
use Commands\HsStock;
use Spiders\GithubSpider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Yaml\Yaml;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $URI_1 = 'https://www.abc.com/a/b/c/d.html';
        $URI_2 = 'https://www.abc.com';
        $URI_3 = '/banner.jpg';

        $test [] = 'http://www.abc.com/css/style.css';
        $test [] = '/img/banner.jpg';
        $test [] = 'images/res_03.png';
        $test [] = '../../js/jquery.min.js';
        $test [] = './../res/js/../jquery/./1.8.3/jquery.js';
        $obj = new HsStock();
        foreach ($test as $val) {
            echo $obj->filterRelativeUrl($val, $URI_1) . PHP_EOL;
        }
        foreach ($test as $val) {
            echo $obj->filterRelativeUrl($val, $URI_2) . PHP_EOL;;
        }

        foreach ($test as $val) {
            echo $obj->filterRelativeUrl($val, $URI_3) . PHP_EOL;;
        }
        // print_r(TaskDocument::find(26)->page_content);
        // $rs = Yaml::parse(file_get_contents(__DIR__.'/validation.yml'));
        // ksort($rs,false);
        // var_export($rs) ;  // $rs = Yaml::parse(file_get_contents(__DIR__.'/validation.yml'));
        // ksort($rs,false);
        // var_export($rs) ;
        // $this->assertTrue(true);
    }



    public function test0()
    {
        $arr = [];
        for ($i = 0; $i < 10000; $i++) {
            $arr[] = json_encode(['sku' => rand(100000000, 999999999), 'batch_no' => uniqid()]);

        }
        file_put_contents(storage_path('data2.json'), json_encode($arr));

    }

    public function test1()
    {
        $t1 = microtime(true);
        $d1 = json_decode(file_get_contents(storage_path('data1.json')), true);
        $d2 = json_decode(file_get_contents(storage_path('data2.json')), true);
        $data1 = [];
        foreach ($d1 as $v) {
            $arr = json_decode($v, true);
            $data1[$arr['sku'] . $arr['batch_no']] = true;// ['json'=>$v,'arr'=>$arr];
        }
        $data2 = [];
        foreach ($d2 as $v) {
            $arr = json_decode($v, true);
            $data2[$arr['sku'] . $arr['batch_no']] = true;//['json'=>$v,'arr'=>$arr];
        }
        $keys1 = array_keys($data1);
        $keys2 = array_keys($data2);
        $i = 0;
        foreach ($keys1 as $v) {
            foreach ($keys2 as $v2) {
                $i++;
                // $arr = json_decode($v,true);
                // $data2[$arr['sku'].$arr['batch_no']] = ['json'=>$v,'arr'=>$arr];
            }

        }

        // dump($i);
        // dump(array_diff_key($data1,$data2));
        // foreach ()
        // dd(microtime(true)-$t1);


    }
}
