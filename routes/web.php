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
    return view('day');
});

Route::get('/day/{date?}', function ($date) {
    $days = DB::table('journal_entries')
        ->selectRaw(' MIN(written_at) as start, MAX(written_at) as end')
        ->first();

    $entries = DB::table('journal_entries')
        ->selectRaw('*')
        ->where('written_at', '=', $date)
        ->get();

    if ($entries->count() > 0) {
        return view('day', [
            'date' => $date,
            'daysAvailable' => json_encode($days),
            'entries' => json_encode($entries)
        ]);
    } else {
        return redirect('/day/' . $days->start);
    }
});


Route::get('/daySource/{date}', function ($date) {
    $entries = DB::table('journal_entries')
        ->selectRaw('*')
        ->where('written_at', '=', $date)
        ->get();

    return $entries;
});
