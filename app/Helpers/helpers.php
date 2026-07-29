<?php

use App\Helpers\DateHelper;

if (!function_exists('bulan_indo')) {
    /**
     * Helper global untuk mendapatkan singkatan bulan Indonesia
     */
    function bulan_indo($monthOrDate): string
    {
        return DateHelper::bulanIndo($monthOrDate);
    }
}

if (!function_exists('bulan_indo_full')) {
    /**
     * Helper global untuk mendapatkan nama bulan penuh Indonesia
     */
    function bulan_indo_full($monthOrDate): string
    {
        return DateHelper::bulanIndoFull($monthOrDate);
    }
}

if (!function_exists('tgl_indo')) {
    /**
     * Helper global untuk format tanggal bahasa Indonesia (misal: 29 AGU 2026)
     */
    function tgl_indo($date, bool $withYear = true): string
    {
        return DateHelper::formatIndo($date, $withYear);
    }
}
