<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/upload', 'UploadController@chunkUpload');
Route::get('/upload', 'UploadController@chunkCheck');

Route::get('/', 'FilesController@index')->middleware('auth');
Route::get('/file/{accessKey}/{fileName?}', 'FilesController@file');
Route::get('/delete/{accessKey}', 'FilesController@delete')->middleware('auth');
Route::get('/download/{accessKey}/{fileName?}', 'FilesController@download');

Route::get('logout', 'Auth\LoginController@logout')->middleware('auth');
Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');