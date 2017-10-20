<?php

namespace Vagrant\Jobs;

use App\Model\Vagrant\Vagrant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Vagrant\VagrantRunner;

class VagrantUp implements ShouldQueue
{
    use SerializesModels, Queueable;

    protected $vagrantId;

    public function __construct($vagrantId)
    {
        $this->vagrantId = $vagrantId;

    }


    public function handle()
    {
        $vagrant = Vagrant::find($this->vagrantId);
        if(empty($vagrant)){
            return;
        }
        $vagrantRunner = new VagrantRunner($vagrant);
        $vagrantRunner->up();
        $vagrant->status = Vagrant::STATUS_RUNNING;
        $vagrant->save();
    }
}