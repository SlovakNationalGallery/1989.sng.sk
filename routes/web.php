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

// TODO replace me wirth welcome page
Route::get('/', function () {
    return view('vue');
});


Route::get('/day', function () {
    return view('vue');
});
