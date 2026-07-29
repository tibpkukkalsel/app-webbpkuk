<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Singkatan Bulan Bahasa Indonesia (3 huruf)
     */
    public const BULAN_INDO = [
        1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR',
        5 => 'MEI', 6 => 'JUN', 7 => 'JUL', 8 => 'AGU',
        9 => 'SEP', 10 => 'OKT', 11 => 'NOV', 12 => 'DES'
    ];

    /**
     * Nama Bulan Bahasa Indonesia Penuh
     */
    public const BULAN_INDO_FULL = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    /**
     * Ambil singkatan nama bulan Indonesia berdasarkan angka bulan (1-12) atau tanggal
     */
    public static function bulanIndo($monthOrDate): string
    {
        if (is_numeric($monthOrDate)) {
            $m = (int) $monthOrDate;
            return self::BULAN_INDO[$m] ?? 'JAN';
        }

        if ($monthOrDate) {
            $m = (int) Carbon::parse($monthOrDate)->format('m');
            return self::BULAN_INDO[$m] ?? 'JAN';
        }

        return 'JAN';
    }

    /**
     * Ambil nama bulan penuh Indonesia berdasarkan angka bulan (1-12) atau tanggal
     */
    public static function bulanIndoFull($monthOrDate): string
    {
        if (is_numeric($monthOrDate)) {
            $m = (int) $monthOrDate;
            return self::BULAN_INDO_FULL[$m] ?? 'Januari';
        }

        if ($monthOrDate) {
            $m = (int) Carbon::parse($monthOrDate)->format('m');
            return self::BULAN_INDO_FULL[$m] ?? 'Januari';
        }

        return 'Januari';
    }

    /**
     * Format tanggal dd BBL YYYY dalam bahasa Indonesia (misal: 29 AGU 2026)
     */
    public static function formatIndo($date, bool $withYear = true): string
    {
        if (!$date) {
            return '';
        }

        $c = Carbon::parse($date);
        $bln = self::bulanIndo((int) $c->format('m'));
        return $c->format('d') . ' ' . $bln . ($withYear ? ' ' . $c->format('Y') : '');
    }

    /**
     * Format tanggal numerik dd/mm/yyyy
     */
    public static function formatNumeric($date): string
    {
        if (!$date) {
            return '';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }

    /**
     * Format rentang tanggal agenda (misal: 19/05/2026 - 22/05/2026)
     */
    public static function formatRentangAgenda($tglAwal, $tglAkhir = null): string
    {
        if (!$tglAwal) {
            return '-';
        }

        $awal = Carbon::parse($tglAwal);
        $res = $awal->format('d/m/Y');

        if ($tglAkhir) {
            $akhir = Carbon::parse($tglAkhir);
            if ($akhir->format('Y-m-d') !== $awal->format('Y-m-d')) {
                $res .= ' - ' . $akhir->format('d/m/Y');
            }
        }

        return $res;
    }
}
