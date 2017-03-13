<?php

namespace app\Services;

use App\Entity\File;
use App\Entity\User;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function storeUploadedFile(string $originalFileName, string $filePath, User $user): File
    {
        $accessKey = self::makeAccessKey();

        $file = new File();
        $file->user()->associate($user);
        $file->access_key = $accessKey;
        $file->original_name = $originalFileName;
        $file->path = $filePath;

        if (PHP_INT_SIZE >= 8) {
            $file->size = Storage::size($filePath);
        } else {
            $file->size = self::realFileSize(storage_path('app/'.$filePath));
        }
        $file->downloads = 0;
        $file->save();

        return $file;
    }

    public static function fileURL(File $file): string
    {
        $url = action('FilesController@file', [$file->access_key, $file->original_name]);
        return $url;
    }

    public static function downloadURL(File $file): string
    {
        $url = action('FilesController@download', [$file->access_key, $file->original_name]);
        return $url;
    }

    /**
     * Calculates file size event if the file is bigger than 2GB and system is 32 bit
     * @param $filePath
     * @return float
     */
    public static function realFileSize(string $filePath): float
    {
        $fp = fopen($filePath, 'r');

        if (!$fp) {
            return 0;
        }

        $pos = 0.0;
        $size = 1073741824.0;
        fseek($fp, 0, SEEK_SET);

        while ($size > 1) {
            fseek($fp, $size, SEEK_CUR);

            if (fgetc($fp) === false) {
                fseek($fp, -$size, SEEK_CUR);
                $size = (int)($size / 2);
            } else {
                fseek($fp, -1, SEEK_CUR);
                $pos += $size;
            }
        }

        while (fgetc($fp) !== false) $pos++;
        fclose($fp);
        return $pos;
    }

    protected static function makeAccessKey(): string
    {
        $key = str_random(10);
        return $key;
    }
}