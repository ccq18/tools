<?php

namespace Tests\Unit;

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
        for($i=0;$i<10000;$i++){
            $arr[] = json_encode(['sku'=>rand(100000000,999999999),'batch_no'=>uniqid()]);

        }
        file_put_contents(storage_path('data2.json'),json_encode($arr));

    }

    public function test1()
    {
        $t1 = microtime(true);
        $d1 = json_decode(file_get_contents(storage_path('data1.json')), true);
        $d2 = json_decode(file_get_contents(storage_path('data2.json')), true);
        $data1 = [];
        foreach ($d1 as $v){
            $arr = json_decode($v,true);
            $data1[$arr['sku'].$arr['batch_no']] = true;// ['json'=>$v,'arr'=>$arr];
        }
        $data2 = [];
        foreach ($d2 as $v){
            $arr = json_decode($v,true);
            $data2[$arr['sku'].$arr['batch_no']] = true;//['json'=>$v,'arr'=>$arr];
        }
        $keys1 = array_keys($data1);
        $keys2 = array_keys($data2);
        $i = 0;
        foreach ($keys1 as $v){
            foreach ($keys2 as $v2){
                $i ++;
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
