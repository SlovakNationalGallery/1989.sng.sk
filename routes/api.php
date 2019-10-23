<?php

use App\Http\Resources\JournalEntry as JournalEntryResource;
use App\Http\Resources\JournalEntryCollection;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/journal-entries/{journalEntry}', function (JournalEntry $journalEntry) {
    return JournalEntryResource::make($journalEntry);
})->name('api.journal-entries.show');

Route::get('/journal-entries', function (Request $request) {
    $tag = $request->query('tag');
    $journalEntries = JournalEntry::whereHas('tags', function($query) use ($tag) {
        if ($tag) $query->where('subject', $tag);
    })->get();

    return new JournalEntryCollection($journalEntries);
})->name('api.journal-entries.index');
