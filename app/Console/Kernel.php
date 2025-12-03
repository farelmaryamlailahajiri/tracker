<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
    \App\Console\Commands\ImportTracerCommand::class,
    \App\Console\Commands\ImportAlumniCommand::class,
    \App\Console\Commands\ImportKepuasanPenggunaCommand::class,
    \App\Console\Commands\ImportInstansiFromSurveyCommand::class,
    \App\Console\Commands\ImportInstansiCommand::class,
    \App\Console\Commands\ImportProfesiFromSurveyCommand::class,
    \App\Console\Commands\ImportProfesiCommand::class,
    \App\Console\Commands\ImportPenggunaLulusanCommand::class,

    ];

    

}
