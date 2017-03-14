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
     * @param $accessKey
     * @param null $fileName
     * @return Response
     */
    public function file($accessKey, $fileName = null)
    {
        $file = File::where('access_key', $accessKey)->first();

        if (!$file || !Storage::exists($file->path))
        {
            return response('File not found', 404);
        }

        return view('file', ['file' => $file]);
    }

    /**
     * @param $accessKey
     * @return Response
     */
    public function download($accessKey)
    {
        $file = File::where('access_key', $accessKey)->first();

        if (!$file || !Storage::exists($file->path))
        {
            return response('File not found', 404);
        }

        $file->downloads++;
        $file->save();

        $filePath = config('filesystems.disks.local.root').'/'.$file->path;

        //ze względu na to, że system jest przeznaczony do obsługi wielkich plików, pobieranie pliku z serwera jest delegowane na dedykowany moduł apacha (mod_xsendfile)
        return response('OK', 200)
            ->header('Content-Type', 'application/force-download')
            ->header('Content-Disposition', 'attachment; filename="'.$file->original_name.'"')
            ->header('X-Sendfile', $filePath);
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