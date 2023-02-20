<?php

namespace App\Checks;

use Illuminate\Support\Facades\Process;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class UptimeCheck extends Check
{
    /**
     * Run Uptime Check
     *
     * @return Spatie\Health\Checks\Result
     */
    public function run(): Result
    {
        $uptime = $this->uptime();
        $result = Result::make();

        $result->shortSummary($uptime);

        $result->meta([
            'uptime_since' => $uptime,
            'uptime' => $uptime,
        ]);

        return $result->ok($uptime);
    }

    /**
     * Get uptime
     */
    public function uptime(): string
    {
        $process = Process::run('cat /proc/uptime');

        $uptime = trim($process->output());

        $uptime = explode(' ', $uptime);
        $uptime = $uptime[0];
        $days = explode('.', (($uptime % 31556926) / 86400));
        $hours = explode('.', ((($uptime % 31556926) % 86400) / 3600));
        $minutes = explode('.', (((($uptime % 31556926) % 86400) % 3600) / 60));

        $time = $days[0] . ' days ' . $hours[0] . ' hours ' . $minutes[0] . ' minutes';

        return $time;
    }
}
