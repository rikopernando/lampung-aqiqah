<?php

namespace App\Http\Controllers;

use App\Produk;
use App\KeranjangBelanja;
use Auth;
use DB;
use Session;
use Illuminate\Http\Request;

class KeranjangBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

        public function tambahProdukKeranjangBelanjaan($id)
    {
        if(!Session::get('session_id')){
            $session_id    = session()->getId();
        }else{
            $session_id = Session::get('session_id');
        }

        $harga_produk = Produk::select()->where('id', $id)->first();

        if (Auth::check() == false) {
            $datakeranjang_belanjaan = KeranjangBelanja::where('session_id', $session_id)->Where('id_produk', $id); 
            $jumlah_produk           = $datakeranjang_belanjaan->first();

            if ($datakeranjang_belanjaan->count() == 0) {            
                Session::put('session_id',$session_id);
            }

            if ($datakeranjang_belanjaan->count() > 0) {
                $total_tambah_produk = 0;
                $datakeranjang_belanjaan->update(['jumlah_produk' => $jumlah_produk->jumlah_produk + 1]);

            } else {
                $total_tambah_produk = 1;
                $produk = KeranjangBelanja::create(['id_produk' => $id, 'session_id' => $session_id, 'jumlah_produk' => 1,'harga_produk'=>$harga_produk->harga_jual]);
            }

        }else{
            $pelanggan = Auth::user()->id;
            $datakeranjang_belanjaan = KeranjangBelanja::where('id_pelanggan', $pelanggan)->Where('id_produk', $id); 
            $jumlah_produk           = $datakeranjang_belanjaan->first();

            if ($datakeranjang_belanjaan->count() == 0) {            
                Session::put('session_id',$session_id);
            }

            if ($datakeranjang_belanjaan->count() > 0) {
             $total_tambah_produk = 0;
             $datakeranjang_belanjaan->update(['jumlah_produk' => $jumlah_produk->jumlah_produk + 1]);

         } else {
             $total_tambah_produk = 1;
             $produk = KeranjangBelanja::create(['id_produk' => $id, 'id_pelanggan' => $pelanggan, 'jumlah_produk' => 1,'harga_produk'=>$harga_produk->harga_jual]);
         }
     }

     return  $total_tambah_produk;

 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
