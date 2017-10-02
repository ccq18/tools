<?php

namespace Commands;


use App\Model\Task;
use Illuminate\Console\Command;
use Spiders\GithubSpider;

class GithubCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github_spider';

    public function handle()
    {
        sleep(60);
        if (Task::count() == 0) {
            $starturls = ['https://github.com/search?utf8=%E2%9C%93&q=php'];
            foreach ($starturls as $v) {
                GithubSpider::gernerateBase($v);
            }

        }
        GithubSpider::run();

    }
}