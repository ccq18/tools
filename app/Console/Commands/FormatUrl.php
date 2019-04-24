<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Util\RequestHelper;

class FormatUrl  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:format-url {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');
        RequestHelper::formatUrlToCode($url);
    }


}