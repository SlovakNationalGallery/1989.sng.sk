<?php

use App\Models\JournalEntry;
use App\Models\Topic;
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
Route::get('/random-topics', 'Api\RandomTopicController@get');
Route::apiResource('journal-entries', 'Api\JournalEntryController', ['as' => 'api']);
Route::get('/vimeo/{id}', function ($id) {

    $client_id = config('vimeo.client_id');
    $client_secret = config('vimeo.client_secret');
    $access_token = config('vimeo.access_token');

    $lib = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);
    $response = $lib->request('/videos/' . $id, [], 'GET');
    return $response['body'];

});
