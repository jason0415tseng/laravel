<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use File;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\wagers::class,
        Commands\RepositoryMakeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //log位置
        $logPath = storage_path('logs/' . date('Ymd'));

        if (!File::isDirectory($logPath)) {
            File::makeDirectory($logPath, 0777, true);
        }

        // 每分鐘執行 
        $schedule->command('wagers:insert')->everyMinute()->withoutOverlapping()->appendOutputTo($logPath . '/wagers.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
