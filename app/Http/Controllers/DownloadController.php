<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\ChunkyUploader;
use App\Services\FileService;
use Auth;
use Illuminate\Support\Facades\View;

class DownloadController extends Controller
{
    /**
     * @return Response
     */
    public function download($accessKey, $fileName = null)
    {
        print $accessKey;
        print $fileName;
        return view('upload')->with('user', Auth::user());
    }
}