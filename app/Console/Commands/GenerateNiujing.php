<?php

namespace App\Console\Commands;

use App\Model\Lang\Word;
use Illuminate\Console\Command;

class GenerateNiujing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate-niujing';

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
        //
        $lines = explode("\n", file_get_contents(resource_path('data/niujing')));
        foreach ($lines as $line) {
            try {
                $isMatch = preg_match('/(.+?)[ \s]+(\S+)/', $line, $match);
                if (count($match) != 3 || !$isMatch) {
                    continue;
                }
                $word = new Word();
                $word->type = 'simple';
                $word->book_id = 2;
                $word->word = $match[1];
                $word->simple_trans = $match[2];
                $word->saveOrFail();
                $this->info($word->word);
            } catch (\Exception $e) {
                $this->info($e->getMessage());
            }

        }
    }
}
