<?php

namespace app\Services;

use App\Entity\File;
use App\Entity\User;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function storeUploadedFile(string $originalFileName, string $filePath, User $user) : string
    {
        $accessKey = self::makeAccessKey();

        $file = new File();
        $file->user()->associate($user);
        $file->access_key = $accessKey;
        $file->original_name = $originalFileName;
        $file->path = $filePath;
        $file->size = Storage::size($filePath);
        $file->downloads = 0;
        $file->save();

        return self::fileURL($file);
    }

    public static function fileURL(File $file) : string
    {
        $url = action('FilesController@file', [$file->access_key, $file->original_name]);
        return $url;
    }

    public static function downloadURL(File $file) : string
    {
        $url = action('FilesController@download', [$file->access_key, $file->original_name]);
        return $url;
    }

    protected static function makeAccessKey() : string
    {
        $key = str_random(10);
        return $key;
    }
}