<?php

namespace app\Services;

use App\Entity\File;
use App\Entity\User;

class FileService
{
    public static function storeUploadedFile(string $originalFileName, string $filePath, User $user) : string
    {
        $accessKey = self::makeAccessKey();

        $file = new File();
        $file->user()->associate($user);
        $file->access_key = $accessKey;
        $file->original_file_name = $originalFileName;
        $file->file_path = $filePath;
        $file->save();

        return self::makeDownloadURL($accessKey, $originalFileName);
    }

    protected static function makeAccessKey() : string
    {
        $key = str_random(10);
        return $key;
    }

    protected static function makeDownloadURL(string $accessKey, string $fileName) : string
    {
        $url = action('DownloadController@download', [$accessKey, $fileName]);
        return $url;
    }
}