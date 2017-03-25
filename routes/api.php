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
    Route::get('/orderList', 'AdminController@orderList')->name('orderList');
    Route::get('/unvalidatedOrderList', 'AdminController@unvalidatedOrderList');
    Route::get('/orderDetail', 'AdminController@orderDetail');
    Route::get('/cancelOrder', 'AdminController@cancelOrder');
    Route::post('/shipOrder', 'AdminController@shipOrder');
});

Route::group(['middleware' => ['ability:Customer']], function()
{
    // Protected route
    Route::get('/addProduct', 'CustomerController@addProduct');
    Route::get('/applyCoupon', 'CustomerController@applyCoupon');
    Route::post('/submitOrder', 'CustomerController@submitOrder');
    // Route::post('/submitPaymentProof', 'CustomerController@submitPaymentProof');
    Route::get('/checkOrderStatus', 'CustomerController@checkOrderStatus');
    Route::get('/checkShipmentStatus', 'CustomerController@checkShipmentStatus');
});

// Authentication route
Route::post('authenticate', 'AuthController@authenticate')->name('authenticate');
Route::get('/test2', 'TestController@test2');
Route::get('/test', 'TestController@test');

// Route::get('/test', 'TestController@test')->name('test');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });