<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Entity\File;
use Auth;

class FilesController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $files = $user->files()->orderBy('created_at', 'DESC')->get();

        return view('upload', ['user' => $user, 'files' => $files]);
    }

    /**
     * @return Response
     */
    public function file($accessKey, $fileName = null)
    {
        $file = File::where('access_key', $accessKey)->first();

//        if (!$file || !Storage::exists($file->path))
//        {
//            return response('File not found', 404);
//        }

        return view('file', ['file' => $file]);
    }

    /**
     * @return Response
     */
    public function download($accessKey, $fileName = null)
    {
        $file = File::where('access_key', $accessKey)->first();

        if (!$file || !Storage::exists($file->path))
        {
            return response('File not found', 404);
        }

        $filePath = config('filesystems.disks.local.root').'/'.$file->path;
        return response()->download($filePath, $fileName);
    }

    public function delete($accessKey)
    {
        $file = File::where('access_key', $accessKey)->first();

        if ($file)
        {
            Storage::delete($file->path);
            $file->delete();
        }

        return redirect()->action('FilesController@index');
    }
}