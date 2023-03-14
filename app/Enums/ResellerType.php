<?php

enum ResellerType: int
{
    case INDIRECT = 0;
    case DIRECT = 1;

    /**
     * Get all status
     */
    public static function getAllValues(): array
    {
        return array_column(ResellerType::cases(), 'value');
    }
}
