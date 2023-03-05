<?php

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

if (! function_exists('random_number')) {
    /**
     * Generate random number with fixed digit
     */
    function random_number(int $digit): string
    {
        $randNumber = sprintf(
            '%04d',
            random_int(1, pow(10, $digit) - 1)
        );

        return $randNumber;
    }
}

if (! function_exists('rupiah_format')) {
    /**
     * Format Rupiah Currency
     */
    function rupiah_format(float $currency, $prefix = 'Rp'): string
    {
        return sprintf(
            '%s%s',
            $prefix,
            number_format(
                $currency,
                0,
                ',',
                '.'
            )
        );
    }
}

if (! function_exists('graph')) {
    /**
     * Generate Graph data
     */
    function graph(Collection $results, string $from, string $to): object
    {
        $results = collect($results)->keyBy('monthNum')->map(function ($item) {
            $item->monthNum = Carbon::parse($item->monthNum);

            return $item;
        });

        $periods = new DatePeriod(Carbon::parse($from), CarbonInterval::month(), Carbon::parse($to));

        $keys = [];
        $values = [];

        foreach ($periods as $period) {
            $monthKey = $period->format('Y-m-') . '01';

            $keys[] = Carbon::parse($period)->isoFormat('MMMM g');
            $values[] = $results->get($monthKey)->total ?? 0;
        }

        return (object) [
            'keys' => $keys,
            'values' => $values,
        ];
    }
}

if (! function_exists('graphMax')) {
    function graphMax(int $max)
    {
        $digits = ($max !== 0 ? floor(log10($max)) : 1);

        return round($max, -($digits)) + (10 ** ($digits < 1 ? $digits + 1 : $digits));
    }
}
