<?php

namespace Commands;


use Illuminate\Console\Command;

class RunAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runadd';

    protected $description = '添加灰度用户名单';
    public function handle()
    {
        dispatch(new AddRunner(1));

    }

}