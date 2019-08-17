<?php

namespace Vagrant\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\Vagrant\Vagrant;
use Ido\Tools\Util\FileBrowser;
use Vagrant\VagrantRunner;

class VagrantReload implements ShouldQueue
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
        $vagrantRunner->reload();
        $vagrant->status = Vagrant::STATUS_RUNNING;
        $vagrant->save();
    }
}