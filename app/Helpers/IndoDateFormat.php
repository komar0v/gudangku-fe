<?php

namespace App\Helpers;

use Carbon\Carbon;

class IndoDateFormat
{
    public static function formatIndo(string $isoTime)
    {
        return Carbon::parse($isoTime, 'UTC')
            ->setTimezone(env('APP_TIMEZONE'))
            ->locale('id')
            ->translatedFormat('d F Y H:i') . ' WIB';
    }

    public static function formatIndoNonUTC(string $timestamp){
        return Carbon::parse($timestamp)
        ->locale('id')
        ->translatedFormat('d F Y H:i') . ' WIB';
    }

    public static function formatTanggalIndo(string $isoTime)
    {
        return Carbon::parse($isoTime, 'UTC')
            ->setTimezone(env('APP_TIMEZONE'))
            ->locale('id')
            ->translatedFormat('d F Y');
    }
}
