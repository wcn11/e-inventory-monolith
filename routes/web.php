<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function (){
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => '/stock'], function (){
        Route::get('/', 'StockController@index')->name('stok');
        Route::get('/trip', 'StockController@trip')->name('stok.trip');
        Route::get('/cek-trip', 'StockController@checkTrip')->name('stok.trip.cek');
        Route::get('/history/{id}/view', 'StockController@view')->name('stok.riwayat.lihat');
        Route::get('/history/{id}/download', 'StockController@downloadPDF')->name('stok.riwayat.download');
        Route::get('/chart', 'StockController@getChartData');
    });

    Route::group(['prefix' => '/category'], function (){
        Route::get('/', 'CategoryController@index')->name('kategori');
        Route::get('/create', 'CategoryController@create')->name('kategori.create');
        Route::post('/store', 'CategoryController@store')->name('kategori.store');
        Route::get('/edit/{id}', 'CategoryController@edit')->name('kategori.edit');
        Route::put('/update/{id}', 'CategoryController@update')->name('kategori.update');
        Route::delete('/destroy/{id}', 'CategoryController@destroy')->name('kategori.destroy');
    });

    Route::group(['prefix' => '/product'], function (){

        Route::get('/', 'ProductController@index')->name('barang');
        Route::get('/create', 'ProductController@create')->name('barang.create');
        Route::post('/store', 'ProductController@store')->name('barang.store');
        Route::get('/edit/{id}', 'ProductController@edit')->name('barang.edit');
        Route::put('/update/{id}', 'ProductController@update')->name('barang.update');
        Route::delete('/destroy/{id}', 'ProductController@destroy')->name('barang.destroy');
    });

//    Route::group(['prefix' => '/peran'], function (){
//
//        Route::get('/', 'RolesController@index')->name('peran');
//        Route::get('/create', 'RolesController@create')->name('peran.create');
//    });

    Route::group(['prefix' => '/user'], function (){

        Route::get('/', 'UserController@index')->name('pengguna');
        Route::get('/create', 'UserController@create')->name('pengguna.create');
        Route::post('/store', 'UserController@store')->name('pengguna.store');
        Route::get('/edit/{id}', 'UserController@edit')->name('pengguna.edit');
        Route::put('/update/1', 'UserController@update')->name('pengguna.update');
    });

    Route::group(['prefix' => '/manual'], function (){

        Route::get('/harga', 'PriceController@index')->name('manual.price');
    });
});


Route::get('/log', function (){
    \Illuminate\Support\Facades\Auth::logout();
    return Redirect::to('login');
})->name('log');
