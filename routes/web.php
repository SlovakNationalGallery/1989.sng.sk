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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/day', function () {
    // TODO some intro page?
    return redirect('/day/1989-10-01');
});

Route::get('/day/{date?}', 'DayController@dayViewParams')->name('day');