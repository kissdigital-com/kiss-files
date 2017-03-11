@extends('layout')

@section('content')
    <h1>Hello {{ $user->name }}</h1>

    <div class="resumable-drop" id="browseButton" style="width:500px;height:400px;border:1px solid red;">
        Drop files here to upload or <a class="resumable-browse"><u>select from your computer</u></a>
    </div>

    @foreach ($files as $file)
        <div class="row fileItem">
            <div class="col-md-6"><input type="text" style="width:100%" value="{{ action('FilesController@file', [$file->access_key, $file->original_name]) }}"/></div>
            <div class="col-md-1">{{ \App\Helpers\HumanReadable::bytesToHuman($file->size) }}</div>
            <div class="col-md-1">{{ $file->created_at->format('d.m.Y') }}</div>
            <div class="col-md-4">
                <a href="{{ \App\Services\FileService::downloadURL($file) }}">Pobierz</a>
                <a href="{{ action('FilesController@delete', [$file->access_key]) }}">Usuń</a></div>
        </div>
    @endforeach

    <div id="fileList">

    </div>


@endsection

@section('scripts')
    <script src="/js/resumable.js"></script>

    <script>

        class FileList {

            add(file) {
                var html = '<div class="row"><div class="col-md-8">' + file.fileName + '</div><div class="col-md-4">Trwa ładowanie</div></div>';
                html += '<div class="row" id="progress-' + file.uniqueIdentifier + '" style="height:4px;background:red;"></div>';
                return html;
            }

            progress(file) {
                var progress = Math.floor(file.progress() * 100);
                $('#progress-' + file.uniqueIdentifier).css('width', progress + '%');
            }

            completed(file, result) {
                alert(result.url);
            }
        }

        var fileList = new FileList();

        var r = new Resumable({
            target: "{{ action('UploadController@chunkUpload') }}",
            fileParameterName: "file",
            chunkSize: 8 * 1024 * 1024,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        r.assignBrowse(document.getElementById('browseButton'));

        r.on('fileAdded', function (file, event) {
            $('#fileList').append(fileList.add(file));
            r.upload();
            console.debug('fileAdded', event);
        });

        r.on('fileProgress', function (file) {
            fileList.progress(file);
        });

        r.on('fileSuccess', function (file, message) {
            var result = JSON.parse(message);
            fileList.completed(file, result);
        });

        //        r.on('fileSuccess', function (file) {
        //            console.debug('fileSuccess', file);
        //        });
        //
        //        r.on('filesAdded', function (array) {
        //            console.debug('filesAdded', array);
        //        });
        //        r.on('fileRetry', function (file) {
        //            console.debug('fileRetry', file);
        //        });
        //        r.on('fileError', function (file, message) {
        //            console.debug('fileError', file, message);
        //        });
        //        r.on('uploadStart', function () {
        //            console.debug('uploadStart');
        //        });
        //        r.on('complete', function () {
        //            console.debug('complete');
        //        });
        //        r.on('progress', function () {
        //            console.debug('progress: ' + r.progress());
        //        });
        //        r.on('error', function (message, file) {
        //            console.debug('error', message, file);
        //        });
        //        r.on('pause', function () {
        //            console.debug('pause');
        //        });
        //        r.on('cancel', function () {
        //            console.debug('cancel');
        //        });
    </script>
@endsection