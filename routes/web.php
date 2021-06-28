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
        Route::get('/opname', 'StockController@opname')->name('stok.opname');

        Route::get('/history/{id}/download', 'StockController@downloadPDF')->name('stok.riwayat.download');
        Route::get('/chart', 'StockController@getChartData');
        Route::get('berita-acara-pdf', 'StockController@downloadAsPDF');
        Route::get('berita-acara-word', 'StockController@downloadAsWORD');
        Route::get('berita-acara-example', 'StockController@example');
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

    Route::group(['prefix' => '/roles'], function (){

        Route::get('/', 'RolesController@index')->name('roles');
        Route::get('/create', 'RolesController@create')->name('roles.create');
        Route::get('/delete/{id}', 'RolesController@delete')->name('roles.delete');
        Route::get('/edit/{id}', 'RolesController@edit')->name('roles.edit');
        Route::get('/search', 'RolesController@search')->name('roles.search');
        Route::get('/give-permission', 'RolesController@givePermission')->name('roles.give.permission');
        Route::get('/role-names', 'RolesController@roles')->name('roles.get.name');
    });

    Route::group(['prefix' => '/permission'], function (){

        Route::get('/', 'PermissionController@index')->name('permission');
        Route::get('/create', 'PermissionController@create')->name('permission.create');
        Route::get('/search', 'PermissionController@search')->name('permission.search');
    });

    Route::group(['prefix' => '/user'], function (){

        Route::get('/', 'UserController@index')->name('user');
        Route::get('/create', 'UserController@create')->name('user.create');
        Route::post('/store', 'UserController@store')->name('user.store');
        Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
        Route::put('/update/{id}', 'UserController@update')->name('user.update');
    });

    Route::group(['prefix' => '/manual'], function (){

        Route::get('/harga', 'PriceController@index')->name('manual.price');
    });
});


Route::get('/logout', function (){
    \Illuminate\Support\Facades\Auth::logout();
    return Redirect::to('login');
})->name('logout');
