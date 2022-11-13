<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('App\Http\Controllers\VisitController@cronDeleteImage')->dailyAt('23:50');
        $schedule->call('App\Http\Controllers\SistemController@updateCheckout')->dailyAt('23:55');
        $schedule->call('App\Http\Controllers\UserRetentionController@apiMember')->dailyAt('01:00');
        $schedule->call('App\Http\Controllers\UserRetentionController@apiTransaksi')->dailyAt('01:05');
        $schedule->command('backup:run --only-db')->weeklyOn(7, '01:00');
        // $schedule->call('App\Http\Controllers\SistemController@cronTest')->everyMinute();
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
