<?php

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
    function rupiah_format(float $currency): string
    {
        return sprintf(
            'Rp%s',
            number_format(
                $currency,
                0,
                ',',
                '.'
            )
        );
    }
}
