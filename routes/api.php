<?php

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

Route::group(['middleware' => ['ability:Admin']], function()
{
    // Protected route
    Route::get('/test2', 'TestController@test2')->name('test2');
});

Route::group(['middleware' => ['ability:Customer']], function()
{
    // Protected route
    Route::get('/test', 'TestController@test')->name('test2');
});

// Authentication route
Route::post('authenticate', 'AuthController@authenticate')->name('authenticate');

// Route::get('/test', 'TestController@test')->name('test');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });