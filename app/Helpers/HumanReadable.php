<?php

namespace App\Helpers;

class HumanReadable
{
    public static function bytesToHuman(float $bytes, int $precision = 1) : string
    {
        $result = '0 bytes';

        if ($bytes > 0)
        {
            $base = log($bytes) / log(1024);
            $suffixes = array(' bytes', ' kB', ' MB', ' GB', ' TB');

            $result = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $result;
    }
}