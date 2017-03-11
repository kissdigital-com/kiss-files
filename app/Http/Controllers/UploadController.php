<?php

namespace App\Http\Controllers;

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

            $downloadURL = FileService::storeUploadedFile($request->input('resumableFilename'), $filePath, Auth::user());
            return response()->json(['url' => $downloadURL]);
        }

        return response('File received', 200);
    }
}