<?php

namespace App\Console;

use App\Console\Commands\lowstock;
use App\Console\Commands\outstandingAmount;
use App\Console\Commands\pendingDelivery;
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
        lowstock::class,
        pendingDelivery::class,
        outstandingAmount::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('stock:low')->everyMinute();
        $schedule->command('pending:delivery')->everyMinute();
        $schedule->command('oustanding:extend')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
