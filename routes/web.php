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


// TODO replace with controller once implemented
Route::get('topics/{id}', ['as' => 'topic', function ($id) {
    return App\Models\Topic::where('slug', $id)->firstOrFail();
}]);
