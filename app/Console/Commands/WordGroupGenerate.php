<?php

namespace App\Console\Commands;

use App\Model\Lang\Word;
use App\Model\Lang\WordGroup;
use Illuminate\Console\Command;

class WordGroupGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:word-group-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(WordGroup::count()>0){
            return;
        }

        $ids = Word::where('book_id', 1)->get()->pluck('id');
        // $readList = [];
        $listId = 0;
        $unitId = 0;
        $nowGroupId = 0;
        foreach ($ids as $k=>$id) {
            //初始化组 单元 小组
            if($k%10==0){
                $nowGroupId++;
            }
            if($k%60==0){
                $unitId++;
            }
            if($k%120==0){
                $listId++;
            }

            $wg = new WordGroup();
            $wg->list_id = $listId;
            $wg->unit_id = $unitId;
            $wg->group_id = $nowGroupId;
            $wg->word_id = $id;
            $wg->save();
            $this->info("{$listId}-{$unitId}-{$nowGroupId}-$id");
        }
    }


}
