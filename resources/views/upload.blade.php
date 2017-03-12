@extends('layout')

@section('content')
    <div class="logout">
        <a href="{{ action('Auth\LoginController@logout') }}">Wyloguj</a>
    </div>

    <h1 style="text-align:center;margin-top:40px;">¡Hola {{ $user->name }}!</h1>

    <div class="uploadField" id="dropField">
        <div class="upload">
            To upload another file, drop it here or <a class="resumable-browse" id="browseButton">select from your
                computer</a>.
        </div>
    </div>

    <div id="fileList">
        @foreach ($files as $file)
            <div class="row file fileTemplate">
                <div class="col-sm-6">
                    <input type="text" class="path" readonly="readonly" value="{{ $file->original_name }}"
                           onclick="this.value = $(this).data('url'); this.select()"
                           data-url="{{ action('FilesController@file', [$file->access_key, $file->original_name]) }}"/>
                </div>
                <div class="col-sm-2 size">{{ \App\Helpers\HumanReadable::bytesToHuman($file->size) }}</div>
                <div class="col-sm-1 date">{{ $file->created_at->format('d.m.Y, H:i') }}</div>
                <div class="col-sm-3 actions">
                    <a href="{{ \App\Services\FileService::downloadURL($file) }}">Pobierz</a>
                    <a href="{{ action('FilesController@delete', [$file->access_key]) }}">Usuń</a></div>
            </div>
        @endforeach
    </div>

@endsection

@section('scripts')
    <script src="/js/resumable.js"></script>

    <script>

        $(document).ready(function () {
            $('.uploadField').on('dragover', function () {
                $('.uploadField').addClass('drop');
            });
            $('.uploadField').on('dragleave', function () {
                $('.uploadField').removeClass('drop');
            });
        });

        class FileList {

            add(file) {
                var rowTemplate = $('.fileTemplate').first().clone();
                $(rowTemplate).children('.size').text('0%');
                $(rowTemplate).children('.date').text('');
                $(rowTemplate).find('.path').val(file.fileName);
                $(rowTemplate).children('.actions').text('Uploading...');

                file.row = rowTemplate;

                return rowTemplate;
            }

            progress(file) {
                var progress = Math.floor(file.progress() * 100);
                $(file.row).css('background', 'linear-gradient(90deg, #00BED3 ' + progress + '%, #fff ' + (progress) + '%)');
                $(file.row).children('.size').text(progress + '%');
            }

            completed(file, result) {
                $(file.row).addClass('uploadSuccessful');
                $(file.row).find('.path').val(result.url);
                $(file.row).find('.path').data('url', result.url);
                $(file.row).children('.actions').text('Upload successful!');
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
        r.assignDrop(document.getElementById('dropField'));

        r.on('fileAdded', function (file, event) {
            $('#fileList').prepend(fileList.add(file));
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