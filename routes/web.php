<?php

use Illuminate\Support\Facades\Route;
use DefStudio\Telegraph\Models\TelegraphChat;

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

    $chat = TelegraphChat::all();
    dd($chat);

// this will use the default parsing method set in config/telegraph.php
    $chat->first()->message('hello')->send();
    return view('welcome');
});
