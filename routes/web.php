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

Route::get('/playground', function () {
    return view('playground');
});

Route::get('/day/{date?}', 'DayController@dayViewParams')->name('day');

Route::get('journal-entries', function () {
    return view('journal_entries');
})->name('journal-entries.index');

Route::get('journal-entries/{journalEntry}', function () {
    return view('journal_entries');
})->name('journal-entries.show');


Route::get('/{slug}/visual-editor', 'TopicController@visualEditor')->name('topic.editor');
Route::post('/{slug}/save', 'TopicController@save')->name('topic.save');
