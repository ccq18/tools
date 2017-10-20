<?php

namespace Commands;

use App\Model\Vagrant\Vagrant;
use Illuminate\Console\Command;
use Vagrant\Jobs\VagrantDestroy;
use Vagrant\Jobs\VagrantHalt;
use Vagrant\Jobs\VagrantInit;
use Vagrant\Jobs\VagrantReload;
use Vagrant\Jobs\VagrantUp;

class VagrantCommand extends Command
{
    protected $signature = 'vagrant {runner}';

    protected $description = 'runner:task or parser';

    protected $baseUrl = null;
    protected $domain = null;
    protected $dom = null;


    public function handle()
    {
        try{
            if($this->argument('runner') == 'init'){
                $template = file_get_contents('/Users/mac/phpcode/service/data/template/Vagrantfile');
                $init = new VagrantInit(uniqid(),$template);
                $init->handle();
            }

            if($this->argument('runner') == 'up'){
                $vagrant = Vagrant::first();
                $init = new VagrantUp($vagrant->id);
                $init->handle();
            }
            if($this->argument('runner') == 'destroy'){
                $vagrant = Vagrant::first();
                $init = new VagrantDestroy($vagrant->id);
                $init->handle();
            }
            if($this->argument('runner') == 'halt'){
                $vagrant = Vagrant::first();
                $init = new VagrantHalt($vagrant->id);
                $init->handle();
            }
            if($this->argument('runner') == 'reload'){
                $vagrant = Vagrant::first();
                $init = new VagrantReload($vagrant->id);
                $init->handle();
            }

        }catch (\Exception $e){

        }


    }
}