<?php

namespace App\Http\Controllers;

use App\Helpers\HumanReadable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ChunkyUploader;
use App\Services\FileService;
use Auth;

class UploadController extends Controller
{

    /**
     * Check if a part of file exists. Needed by resumable.js
     *
     * @return Response
     */
    public function chunkCheck(Request $request)
    {
        if (ChunkyUploader::chunkExists($request))
        {
            return response('File exists', 200);
        }

        return response('File not found', 404);
    }

    /**
     * Handle upload one part of file
     *
     * @return Response
     */
    public function chunkUpload(Request $request)
    {
        ChunkyUploader::storeChunk($request);

        if (ChunkyUploader::isUploadCompleted($request))
        {
            $filePath = ChunkyUploader::mergeUploadedFile($request);
            ChunkyUploader::clean($request);

            $file = FileService::storeUploadedFile($request->input('resumableFilename'), $filePath, Auth::user());
            $downloadURL = FileService::downloadURL($file);
            $size = HumanReadable::bytesToHuman($file->size);
            $created_at = $file->created_at->format('d.m.Y, H:i');
            return response()->json(['size' => $size, 'created_at' => $created_at, 'url' => $downloadURL]);
        }

        return response('File received', 200);
    }
}