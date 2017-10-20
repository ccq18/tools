<?php

namespace Vagrant\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\Vagrant\Vagrant;
use Util\FileBrowser;
use Vagrant\VagrantRunner;

class VagrantDestroy implements ShouldQueue
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
        $vagrantRunner->destroy();
        $f = new FileBrowser();
        $f->deldir($vagrant->path);
        $vagrant->delete();
    }
}