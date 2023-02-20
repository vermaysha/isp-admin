<?php

namespace App\Checks;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
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

        $uptimeHuman = str_replace(
            ['before', 'ago'],
            '',
            $uptime->diffForHumans(
                now(),
                CarbonInterface::DIFF_RELATIVE_AUTO,
                false, 6
            )
        );

        $result->shortSummary($uptimeHuman);

        $result->meta([
            'uptime_since' => $uptime->toIso8601String(),
            'uptime' => $uptimeHuman,
        ]);

        return $result->ok($uptimeHuman);
    }

    /**
     * Get uptime
     *
     * @return Illuminate\Support\Carbon
     */
    public function uptime(): Carbon
    {
        $process = Process::run('uptime -s');

        $uptime = trim($process->output());

        return Carbon::parse($uptime)->locale('en');
    }
}
