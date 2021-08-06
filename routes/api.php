<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => 'auth:api'], function (){

    Route::get('/user', 'StockController@coba');
    Route::delete('/user/delete/{id}', 'API\UserController@destroy')->name('api.user.delete');


    Route::delete('/category/destroy/{id}', 'CategoryController@destroy');


    Route::group(['prefix' => '/limit'], function () {

        Route::get('/', 'API\LimitController@index');
        Route::delete('/{id}', 'API\LimitController@delete');
        Route::get('/search', 'API\LimitController@search');
        Route::put('/product', 'API\LimitController@setLimit');

    });

    Route::group(['prefix' => '/stock'], function () {

        Route::post('/upload', 'StockController@storeUpload');
        Route::get('/chart', 'StockController@getChartData');

        Route::group(['prefix' => '/opname'], function () {
            Route::get('/', 'API\StockController@getProducts')->name('stok.opname.products');
            Route::post('/store', 'API\StockController@opnameStore')->name('stok.opname.store');
            Route::post('/store/confirm', 'API\StockController@storeConfirmed')->name('stok.opname.confirm');
        });

        Route::group(['prefix' => '/request'], function () {
            Route::delete('/{sjId}', 'API\StockController@requestDelete')->name('api.stok.request.delete');
            Route::post('/store/{sjId}', 'API\StockController@requestStore')->name('api.stok.request.store');
            Route::post('/process/{sjId}', 'API\StockController@process')->name('api.stok.request.process');
            Route::put('/confirm/{orderId}', 'API\StockController@requestConfirmed')->name('api.stok.request.confirm');
        });

    });

    Route::group(['prefix' => '/roles'], function () {

        Route::post('/create', 'API\RolesController@create')->name('api.roles.create');
        Route::put('/{id}/update', 'API\RolesController@update')->name('api.roles.update');

    });
});
