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
        //\App\Console\Commands\ParseEmail::class,
        \App\Console\Commands\FileParser::class,
        \App\Console\Commands\EmailReader::class,
        \App\Console\Commands\Test::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
            // $schedule->command('cron:parseemail')->everyMinute()->withoutOverlapping();
            $schedule->command('cron:emailreader')->everyMinute()->withoutOverlapping();
            // $schedule->command('cron:fileparser')->everyMinute()->withoutOverlapping();
            // $schedule->command('cron:test')->everyMinute()->withoutOverlapping();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
//        $this->load(__DIR__.'/Commands');
//        require base_path('routes/console.php');
    }
}
