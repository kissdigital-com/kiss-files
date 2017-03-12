@extends('layout')

@section('content')

    <div class="center">
        <div>
            <h1>¡Hola! Your file is awaiting...</h1>
            <h2>Just click the button below to download <strong>{{ $file->original_name }}
                    ({{ \App\Helpers\HumanReadable::bytesToHuman($file->size) }})</strong></h2>
            <div style="text-align:center;padding-top:40px;">
                <a href="{{ \App\Services\FileService::downloadURL($file) }}" class="button">
                    <span>Get the file now!</span>
                </a>
            </div>
        </div>
    </div>

@endsection