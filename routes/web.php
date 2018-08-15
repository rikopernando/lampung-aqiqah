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
Route::get('/produk/view-produk/{tampil_produk}', 'DaftarProdukController@viewProduk');
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
Route::get('/bank/update-default-bank/{id}/{boolean}', 'BankController@updateDefaultBank');
Route::get('/bank/count-default', 'BankController@countDefault');
Route::resource('bank', 'BankController');
//Produk
Route::get('/produk/view', 'ProdukController@view');
Route::post('/produk/{id}', 'ProdukController@update');
Route::get('/produk/update-tampil-produk/{id}/{boolean}', 'ProdukController@updateTampilProduk');
Route::get('/produk/jumlah-tampil', 'ProdukController@jumlahTampil');
Route::resource('produk', 'ProdukController');

// Laporan Order
Route::get('laporan-order/view', 'LaporanOrderController@view');

// Pesanan
Route::get('pesanan/provinsi', 'PesananController@provinsi');
Route::get('pesanan/pilih-wilayah/{id}/{type}', 'PesananController@pilih_wilayah');
Route::get('pesanan/history-order', 'PesananController@history_order');
Route::get('pesanan/detail-order/{id}', 'PesananController@detail_order');
Route::resource('pesanan', 'PesananController');


Route::post('/keranjang-belanja/create/{id}/{jumlah_produk}', 'KeranjangBelanjaController@tambahProdukKeranjangBelanjaan');
Route::get('/keranjang-belanja/view', 'KeranjangBelanjaController@view');
Route::get('/keranjang-belanja/subtotal-keranjang-belanja','KeranjangBelanjaController@cekSubtotalKeranjangBelanja');
Route::post('/keranjang-belanja/edit-jumlah-keranjang/{id}/{operator}', 'KeranjangBelanjaController@editJumlahKeranjang');
Route::post('/keranjang-belanja/jumlah-pesanan', 'KeranjangBelanjaController@jumlahPesanan');
Route::resource('keranjang-belanja', 'KeranjangBelanjaController');

//Testimoni
Route::get('/testimoni/view', 'TestimoniController@view');
Route::resource('testimoni', 'TestimoniController');
