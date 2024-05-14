<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
    // $images = [];
    // $files = Storage::disk('s3')->files('images');
    // foreach ($files as $file) {
    //     $images[] = [
    //         'name' => str_replace('images/', '', $file),
    //         'src' => $url . $file
    //     ];
    // }

    dd(Storage::disk('s3')->put('s', file_get_contents(public_path('d.png'))));
    // dd(Storage::disk('s3')->exists('mak.txt'));
    // dd(Storage::disk('s3')->put('1', public_path('d.png')), public_path('d.png'));

    // return view('welcome');
});

// Route::redirect('/', env('APP_FRONT_URL', 'https://staging.maksb.sa/'));
