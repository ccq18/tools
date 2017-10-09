<?php

namespace Tests\Feature;


use PnctlProcess\Process;
use Tests\TestCase;

class DemoProcess extends Process
{
    protected $r=0;

    public function __construct($r)
    {
        $this->r = $r;

    }
    protected function run()
    {
        $i = 0;
        while ($i <1){
            echo "id:".$this->r." this is child".PHP_EOL;
            $i++;
            sleep(1);
        }
        // TODO: Implement run() method.
    }
}


$i = 0;
while ($i <1000){
    $p = new DemoProcess($i);
    $p->start();
    // echo 'this is main'.PHP_EOL;
    $i++;

}
sleep(11);

class ProcessTest extends TestCase
{

    public function testProcess()
    {


    }
}