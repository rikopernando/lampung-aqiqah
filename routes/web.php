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

route::get('/auth', 'AuthController@auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// User
Route::get('/user/view', 'UserController@view');
Route::resource('user', 'UserController');

//Bank
Route::get('/bank/view', 'BankController@view');
Route::resource('bank', 'BankController');
//Produk
Route::get('/produk/view', 'ProdukController@view');
Route::get('/produk/view-produk', 'ProdukController@viewProduk');
Route::get('/produk/view-produk-terbaru', 'ProdukController@viewProdukTerbaru');
Route::get('/produk/sort-produk/{filter}', 'ProdukController@sortProduk');
Route::post('/produk/{id}', 'ProdukController@update');
Route::post('/produk/{id}', 'ProdukController@update');
Route::resource('produk', 'ProdukController');

//Keranjang Belanja
Route::post('/keranjang-belanja/create/{id}', 'KeranjangBelanjaController@tambahProdukKeranjangBelanjaan');


