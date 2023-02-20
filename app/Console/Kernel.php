<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunHealthChecksCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Auto Generate new bill
        $schedule->command('bill:generate')
            ->runInBackground()
            ->withoutOverlapping()
            ->monthly();

        $schedule->command('backup:clean')
            ->runInBackground()
            ->withoutOverlapping()
            ->name('Auto remove all backups')
            ->evenInMaintenanceMode()
            ->dailyAt('00:00');

        $schedule->command('backup:run', ['--only-db'])
            ->runInBackground()
            ->withoutOverlapping()
            ->name('Auto backup database')
            ->evenInMaintenanceMode()
            ->dailyAt('00:00');

        $schedule->command(RunHealthChecksCommand::class)
            ->runInBackground()
            ->withoutOverlapping()
            ->name('Run Health Checks')
            ->evenInMaintenanceMode()
            ->everyMinute();
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

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return config('app.timezone');
    }
}
