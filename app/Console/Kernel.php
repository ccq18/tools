<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \Commands\GithubCommand::class,
        \Commands\HsStock::class,
        \Commands\CodeLine::class,
        \Commands\UpHsStock::class,
        \Commands\VagrantCommand::class,
        \Commands\GetWords::class,
        \App\Console\Commands\BuildSent::class,
        \App\Console\Commands\WordGroupGenerate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('up-hs-stock')
                 ->dailyAt('16:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
