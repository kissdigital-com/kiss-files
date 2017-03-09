<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\ChunkyUploader;

class UploadController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return view('upload');
    }

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
            ChunkyUploader::mergeUploadedFile($request);
            ChunkyUploader::clean($request);
        }

        return response('File received', 200);
    }
}