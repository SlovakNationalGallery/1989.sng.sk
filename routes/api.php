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

Route::post('/subscribe', 'SubscriptionController@store');
Route::apiResource('journal-entries', 'Api\JournalEntryController', ['as' => 'api']);
