<?php

namespace Vagrant\Jobs;

use App\Model\Vagrant\Vagrant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Vagrant\VagrantRunner;

class VagrantInit implements ShouldQueue
{
    use SerializesModels, Queueable;

    protected $name, $vagrant_file;

    public function __construct($name, $vagrant_file)
    {
        $this->name = $name;
        $this->vagrant_file = $vagrant_file;
    }


    public function handle()
    {
        $vagrant = new Vagrant();
        $vagrant->name = $this->name;
        $vagrant->path = generate_path(Vagrant::BASE_PATH, uniqid());
        $vagrant->vagrant_file = $this->vagrant_file;//'/Users/mac/phpcode/service/data/template/Vagrantfile';
        $vagrant->status = Vagrant::STATUS_CREATED;
        $vagrant->save();

        //创建主目录
        mkdir($vagrant->path, 0777, true);
        //配置vagrant
        file_put_contents(
            generate_path($vagrant->path, 'Vagrantfile'),
            $this->vagrant_file
        );
        $up = new VagrantUp($vagrant->id);
        $up->handle();

    }
}