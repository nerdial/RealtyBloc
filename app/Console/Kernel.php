<?php

namespace App\Console;

use App\Models\Engine;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $engines = cache()->remember('engines', 10, function () {
            return Engine::where('status', 1)->get();
        });

        foreach ($engines as $engine){
            $minute =  60 / $engine->rate_limit;
            $time = "*/{$minute} * * * *";
            $schedule->command($engine->class_name)->cron($time);
        }

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
