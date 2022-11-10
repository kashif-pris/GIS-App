<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Api\V1\Auth\LocationController_1;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\checkIn::class,
        Commands\MarkCheckIn::class,
        Commands\MarkCheckOut::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $new_time = Carbon::now()->format('h:i: A');


        // $schedule->call('App\Http\Controllers\Api\V1\Auth\LocationController_1@checkOneSginal_1')->everyThirtyMinutes();
        $schedule->call('App\Http\Controllers\Api\V1\Auth\LocationController_1@checkOneSginal_1')->everyMinute();
        // $schedule->call('App\Http\Controllers\Api\V1\Auth\LocationController_1@checkOutAttendance')->everyMinute();
        // $schedule->call('App\Http\Controllers\Api\V1\Auth\LocationController_1@checkOneSginal_1')->everyMinute();
      
        


        // $schedule->command('checkout:cron')->everyminute();

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
