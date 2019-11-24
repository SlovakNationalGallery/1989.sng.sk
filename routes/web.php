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

use App\Models\JournalEntry as JournalEntry;

Route::get('/', 'DayController@index')->name('days.index');;

Route::get('/{day}', 'DayController@show')
    ->where('day', '^\d{4}-\d{2}-\d{2}$')
    ->name('days.show');

Route::get('dennik/{journalEntry}', function (JournalEntry $journalEntry) {
    return view('journal_entries', compact('journalEntry'));
})->name('journal-entries.show');

Route::get('/day/{day}', function ($day) {
    return redirect()->route('days.show', $day);
});

Route::get('coming-soon', function () {
    return view('welcome');
});

Route::get('/playground', function () {
    return view('playground');
});

Route::get('/{topic}', 'TopicController@show')->name('topics.show');
Route::get('/{topic}/edit', 'TopicController@edit')->name('topics.edit');
Route::match(['put', 'patch'], '/{topic}', 'TopicController@update')->name('topics.update');
