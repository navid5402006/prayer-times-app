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
        \App\Console\Commands\UpdateRamadanMetaData::class, // Naya command (sab kuch update karega)
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 🟢 Rozana update - Sirf 3 din purani records (meta title, description, keywords, main)
        $schedule->command('ramadan:update-meta --chunk=50')
                 ->dailyAt('01:00')
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-meta-daily.log'));

        // 🔴 Haftawar full update - Force update all records (har Monday)
        $schedule->command('ramadan:update-meta --force --chunk=100')
                 ->weeklyOn(1, '02:00') // 1 = Monday
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-meta-weekly.log'));

        // 🟡 Har 6 ghante mein important cities ka update
        $schedule->command('ramadan:update-meta --city=Karachi --force')
                 ->everySixHours()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-karachi.log'));

        $schedule->command('ramadan:update-meta --city=Lahore --force')
                 ->everySixHours()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-lahore.log'));

        $schedule->command('ramadan:update-meta --city=Islamabad --force')
                 ->everySixHours()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-islamabad.log'));

        $schedule->command('ramadan:update-meta --city=Dubai --force')
                 ->everySixHours()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/ramadan-dubai.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}