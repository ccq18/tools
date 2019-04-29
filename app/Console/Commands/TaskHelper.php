<?php

namespace App\Console\Commands;


use App\Model\Task;
use Illuminate\Console\Command;

class TaskHelper extends Command
{
    protected $signature = 'task {type}';

    public function handle()
    {
        $type = $this->argument('type');
        if($type == 'init'){

            Task::whereStatus(Task::STATUS_RUNNING)->update(
                ['status'=>Task::STATUS_INIT]
            );
            $this->info($type.' success');
        }
        if($type == 'retry'){
            Task::query()->update(
                ['status'=>Task::STATUS_INIT]
            );
            $this->info($type.' success');
        }

    }

}