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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        echo "schedulesssss";

        // mail all
        $schedule->command('mail:all')->everyMinute();

        // quet mail box (register)  -> dang ky user moi
        //$schedule->command('mail:register')->everyMinute();

        // quet mail box (contact)  -> dang ky comtact
        $schedule->command('mail:contact')->everyFiveMinutes();

        // $schedule->command('mail:delete')->dailyAt('23:00');
        //$schedule->command('mail:delete')->everyMinute();
        // $schedule->command('db:backup')->dailyAt('23:00');
        // $schedule->command('db:important')->hourlyAt('15');
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
