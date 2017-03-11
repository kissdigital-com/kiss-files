@extends('layout')

@section('content')

    <div class="center">
        <div>
            <h1>Hello! Your file is awaiting...</h1>
            <a  href="{{ \App\Services\FileService::downloadURL($file) }}" class="download">
                {{ $file->original_name }} ({{ \App\Helpers\HumanReadable::bytesToHuman($file->size) }})
                <span>Get it!</span>
            </a>
        </div>
    </div>

@endsection