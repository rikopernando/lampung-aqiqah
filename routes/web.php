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

//Daftar Produk
Route::get('/produk/view-produk', 'DaftarProdukController@viewProduk');
Route::get('/produk/view-produk-terbaru', 'DaftarProdukController@viewProdukTerbaru');
Route::get('/produk/sort-produk/{filter}', 'DaftarProdukController@sortProduk');
Route::get('/produk/lihat-detail/{id_produk}', 'DaftarProdukController@detailProduk');


route::get('/auth', 'AuthController@auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// User
Route::get('/user/view', 'UserController@view');
Route::get('/user/detail-akun', 'UserController@detailAkun');
Route::put('/user/simpan-detail-akun', 'UserController@simpanDetailAkun');
Route::put('/user/simpan-alamat', 'UserController@simpanAlamat');
Route::resource('user', 'UserController');

//Bank
Route::get('/bank/view', 'BankController@view');
Route::resource('bank', 'BankController');
//Produk
Route::get('/produk/view', 'ProdukController@view');
Route::post('/produk/{id}', 'ProdukController@update');
Route::resource('produk', 'ProdukController');



// Pesanan
Route::get('pesanan/provinsi', 'PesananController@provinsi');
Route::get('pesanan/pilih-wilayah/{id}/{type}', 'PesananController@pilih_wilayah');
Route::resource('pesanan', 'PesananController');


Route::post('/keranjang-belanja/create/{id}/{jumlah_produk}', 'KeranjangBelanjaController@tambahProdukKeranjangBelanjaan');
Route::get('/keranjang-belanja/view', 'KeranjangBelanjaController@view');
Route::get('/keranjang-belanja/subtotal-keranjang-belanja','KeranjangBelanjaController@cekSubtotalKeranjangBelanja');
Route::post('/keranjang-belanja/edit-jumlah-keranjang/{id}/{operator}', 'KeranjangBelanjaController@editJumlahKeranjang');
Route::post('/keranjang-belanja/jumlah-pesanan', 'KeranjangBelanjaController@jumlahPesanan');
Route::resource('keranjang-belanja', 'KeranjangBelanjaController');
