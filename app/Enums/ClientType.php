<?php

namespace App\Enums;

enum ClientType: int
{
    /**
     * Direct Client
     */
    case DIRECT_CLIENT = 0;

    /**
     * Indirect Client
     */
    case INDIRECT_CLIENT = 1;
}
