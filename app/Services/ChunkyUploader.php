<?php

namespace app\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChunkyUploader
{
    const TEMP_FOLDER ="tmp";
    const UPLOADS_FOLDER ="uploads";

    public static function chunkExists(Request $request)
    {
        return Storage::has(self::getChunkFilePath($request));
    }

    public static function storeChunk(Request $request)
    {
        $uploadedFile = $request->file('file');
        $uploadedFile->storeAs(self::getChunkDirectory($request), self::getChunkFileName($request));
    }

    public static function isUploadCompleted(Request $request) : bool
    {
        $expectedSize = $request->input('resumableTotalSize', 0);
        $directory = self::getChunkDirectory($request);

        if (self::countDirectorySize($directory) >= $expectedSize)
        {
            return true;
        }

        return false;
    }

    public static function mergeUploadedFile(Request $request) : string
    {
        $resumableTotalChunks = $request->input('resumableTotalChunks', 0);
        $resumableFilename =  $request->input('resumableFilename', '');

        Storage::makeDirectory(self::UPLOADS_FOLDER);

        $targetFilePath = self::UPLOADS_FOLDER.'/'.$resumableFilename;

        $index = 1;
        while (Storage::has($targetFilePath))
        {
            $index++;
            $targetFilePath = self::addSuffixToFilename($targetFilePath, '-'.$index);
        }

        $fp = fopen(storage_path('app/'.$targetFilePath), 'w');

        if ($fp === false)
        {
            throw new \Exception('Cannot open file for writing '.storage_path('app/'.$targetFilePath));
        }

        for ($i = 1; $i <= $resumableTotalChunks; $i++)
        {
            $partFile = self::getChunkDirectory($request).'/'.$resumableFilename.'.part'.$i;
            //Storage::append($targetFilePath, Storage::get($partFile)); //NIESTETY... Allowed memory size of 134217728 bytes exhausted
            fwrite($fp, file_get_contents(storage_path('app/'.$partFile)));
        }

        fclose($fp);

        return $targetFilePath;
    }

    public static function clean(Request $request)
    {
        Storage::deleteDirectory(self::getChunkDirectory($request));
    }

    public static function countDirectorySize($directory) : float
    {
        $files = Storage::files($directory);
        $calculatedSize = 0;

        foreach ($files as $file)
        {
            $calculatedSize += Storage::size($file);
        }

        return $calculatedSize;
    }

    public static function addSuffixToFilename($filePath, $suffix) : string
    {
        $parts = explode('/', $filePath);
        $lastPart = end($parts);

        if (($dotPosition = strpos($lastPart, '.')) !== false && strpos($lastPart, '.') !== strlen($lastPart) - 1)
        {
            $extensions = substr($lastPart, $dotPosition);
            $suffixedName = substr($filePath, 0, strlen($filePath) - (strlen($extensions))) . $suffix . $extensions;
        }
        else
        {
            $suffixedName = $filePath . $suffix;
        }

        return $suffixedName;
    }

    public static function getChunkFilePath(Request $request) : string
    {
        return self::getChunkDirectory($request).'/'.self::getChunkFileName($request);
    }

    public static function getChunkFileName(Request $request) : string
    {
        $resumableFilename = $request->input('resumableFilename', '');
        $resumableChunkNumber = $request->input('resumableChunkNumber', '');

        $chunkFilePath = $resumableFilename.'.part'.$resumableChunkNumber;

        return $chunkFilePath;
    }

    public static function getChunkDirectory(Request $request) : string
    {
        $resumableIdentifier = $request->input('resumableIdentifier', '');
        return self::TEMP_FOLDER.'/'.$resumableIdentifier;
    }
}