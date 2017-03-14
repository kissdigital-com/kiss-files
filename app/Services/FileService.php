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
            //na systemach 32 bit nie możemy wykorzystać wbudowanego w PHP sprawdzania wielkości plików, bo dla plików >2GB zwraca nieprawidłowe wartości
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
        $line = exec('ls -l '.escapeshellarg($filePath));
        $line = preg_replace('!\s+!', ' ', $line);
        $elements = explode(' ', $line);
        $size = (float)$elements[4];
        return $size;
    }

    protected static function makeAccessKey(): string
    {
        $key = str_random(10);
        return $key;
    }
}