<?php

namespace Commands;


use Illuminate\Console\Command;
use PnctlProcess\DemoProcess;

class Runner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runner';

    protected $description = 'runner';



    public function handle()
    {

        // for ($j = 0; $j < 100; $j++) {
        //     for ($i = 0; $i < 10000; $i++) {
        //         dispatch(new AddRunner($i));
        //     }
        //     echo "runed: $j".PHP_EOL;
        //     sleep(10);
        // }
        (new DemoProcess())->run();
    }

    public function add($callback,$time)
    {

    }

}