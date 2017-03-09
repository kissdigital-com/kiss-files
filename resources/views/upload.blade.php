@extends('layout')

@section('content')
  <h1>Hello</h1>

  <div class="resumable-drop" id="browseButton" style="width:500px;height:400px;border:1px solid red;">
    Drop files here to upload or <a class="resumable-browse"><u>select from your computer</u></a>
  </div>

@endsection

@section('scripts')
  <script src="/js/resumable.js"></script>
  <script>
  var r = new Resumable({
    target: "{{ action('UploadController@chunkUpload') }}",
    fileParameterName: "file",
    chunkSize: 8 * 1024 * 1024,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });

  r.assignBrowse(document.getElementById('browseButton'));

  r.on('fileSuccess', function(file){
      console.debug('fileSuccess',file);
    });
  r.on('fileAdded', function(file, event){
      r.upload();
      console.debug('fileAdded', event);
    });
  r.on('filesAdded', function(array){
      r.upload();
      console.debug('filesAdded', array);
    });
  r.on('fileRetry', function(file){
      console.debug('fileRetry', file);
    });
  r.on('fileError', function(file, message){
      console.debug('fileError', file, message);
    });
  r.on('uploadStart', function(){
      console.debug('uploadStart');
    });
  r.on('complete', function(){
      console.debug('complete');
    });
  r.on('progress', function(){
      console.debug('progress: ' + r.progress());
    });
  r.on('error', function(message, file){
      console.debug('error', message, file);
    });
  r.on('pause', function(){
      console.debug('pause');
    });
  r.on('cancel', function(){
      console.debug('cancel');
    });
  </script>
@endsection