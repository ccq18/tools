<?php

namespace App\Console\Commands;

use App\Model\Lang\Word;
use Illuminate\Console\Command;

class InitCETSix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:initcet6';

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
        $lines = explode("\n", file_get_contents(resource_path('data/cet6.txt')));
        $lines = collect($lines)->shuffle()->values()->all();
        foreach ($lines as $k=>$line) {
            try {
                $isMatch = preg_match('/(.+?)[ 　\s\t]+(\S+)/', $line, $match);
                if (count($match) != 3 || !$isMatch) {
                    continue;
                }
                $w = Word::where('word', $match[1])->first();
                if (!empty($w)) {
                    $info = $w->toArray();
                    unset($info['id']);
                    unset($info['created_at']);
                    unset($info['updated_at']);
                    unset($info['book_id']);
                    $word = new Word($info);
                } else {
                    $word = new Word();
                    $word->type = 'simple';

                    $word->word = $match[1];
                    $word->simple_trans = $match[2];

                }
                $word->number = $k+1;
                $word->book_id = 3;
                $word->saveOrFail();
                $this->info($word->word);
            } catch (\Exception $e) {
                $this->info($e->getMessage());
            }

        }
    }
}