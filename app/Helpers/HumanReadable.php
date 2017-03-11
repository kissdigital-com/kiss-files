<?php

namespace App\Helpers;

class HumanReadable
{
    public static function bytesToHuman($bytes, $precision = 1)
    {
        if ($bytes > 0)
        {
            $bytes = (int)$bytes;
            $base = log($bytes) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $bytes;
    }
}