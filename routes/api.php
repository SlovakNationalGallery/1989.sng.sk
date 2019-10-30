<?php

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

Route::get('/day/{date}', function ($date) {
    return JournalEntry::where('written_at', '=', $date)->get();
})->name('api.day');

Route::post('/subscribe', 'SubscriptionController@store');
Route::apiResource('journal-entries', 'Api\JournalEntryController', ['as' => 'api']);
