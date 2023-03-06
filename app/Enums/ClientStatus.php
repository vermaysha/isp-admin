<?php

namespace App\Enums;

enum ClientStatus: int
{
    /**
     * Internet Reseller Belum Terpasang
     */
    case NOT_INSTALLED = 0;

    /**
     * Internet Reseller Sudah Terpasang dan sudah aktif
     */
    case ACTIVED = 1;

    /**
     * Pelanggan Terblokir
     */
    case BLOCKED = 2;

    /**
     * Pelanggan berhenti sementara
     */
    case INACTIVE = 3;
}
