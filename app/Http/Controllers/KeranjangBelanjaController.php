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
        $subtotal = $harga_produk->harga_jual * 1;

        if (Auth::check() == false) {
            $datakeranjang_belanjaan = KeranjangBelanja::where('session_id', $session_id)->Where('id_produk', $id); 
            $jumlah_produk           = $datakeranjang_belanjaan->first();

            if ($datakeranjang_belanjaan->count() == 0) {            
                Session::put('session_id',$session_id);
            }

            if ($datakeranjang_belanjaan->count() > 0) {
                $total_tambah_produk = 0;
                $jumlah_update = $jumlah_produk->jumlah_produk + 1;
                $subtotal_update = $subtotal * $jumlah_update;
                $datakeranjang_belanjaan->update(['jumlah_produk' => $jumlah_produk->jumlah_produk + 1,'subtotal'=> $subtotal_update]);

            } else {
                $total_tambah_produk = 1;
                $produk = KeranjangBelanja::create(['id_produk' => $id, 'session_id' => $session_id, 'jumlah_produk' => 1,'harga_produk'=>$harga_produk->harga_jual,'subtotal'=> $subtotal]);
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
                $jumlah_update = $jumlah_produk->jumlah_produk + 1;
                $subtotal_update = $subtotal * $jumlah_update;
                $datakeranjang_belanjaan->update(['jumlah_produk' => $jumlah_produk->jumlah_produk + 1,'subtotal'=> $subtotal_update]);
         } else {
             $total_tambah_produk = 1;
             $produk = KeranjangBelanja::create(['id_produk' => $id, 'id_pelanggan' => $pelanggan, 'jumlah_produk' => 1,'harga_produk'=>$harga_produk->harga_jual,'subtotal'=> $subtotal]);
         }
     }

     return  $total_tambah_produk;

 }


        public function cekSubtotalKeranjangBelanja()
    {
        if(!Session::get('session_id')){
            $session_id    = session()->getId();
        }else{
            $session_id = Session::get('session_id');
        }

        if (Auth::check() == false) {
            $datasubtotal  = KeranjangBelanja::select([DB::raw('SUM(subtotal) as subtotal')])->where('session_id',$session_id)->first();
                
                if ($datasubtotal->subtotal == null || $datasubtotal->subtotal == '') {
                   $subtotals = 0;
                }else{
                   $subtotals = $datasubtotal->subtotal;
                }

            $respons['subtotal'] = $subtotals;
        }
        else{
             $pelanggan = Auth::user()->id;

             $datasubtotal  = KeranjangBelanja::select([DB::raw('SUM(subtotal) as subtotal')])->where('id_pelanggan',$pelanggan)->first();
                
                if ($datasubtotal->subtotal == null || $datasubtotal->subtotal == '') {
                   $subtotals = 0;
                }else{
                   $subtotals = $datasubtotal->subtotal;
                }

            $respons['subtotal'] = $subtotals;
        }


        return response()->json($respons);
    }

        public function view()
    {
        if(!Session::get('session_id')){
            $session_id    = session()->getId();
        }else{
            $session_id = Session::get('session_id');
        }

        if (Auth::check() == false) {
            $keranjang_belanjaan = KeranjangBelanja::with(['produk'])->where('session_id', $session_id)->orderBy('id_keranjang_belanja','desc')->get();

        }else{
            $keranjang_belanjaan = KeranjangBelanja::with(['produk'])->where('id_pelanggan', Auth::user()->id)->orderBy('id_keranjang_belanja','desc')->get();  
   
        }


        return response()->json($keranjang_belanjaan);

    }

        public function tambahJumlahKeranjang($id){

        if(!Session::get('session_id')){
            $session_id    = session()->getId();
        }else{
            $session_id = Session::get('session_id');
        }

        if (Auth::check() == false) {
            $keranjang_belanjaan = KeranjangBelanja::select()->where('session_id', $session_id)->where('id_produk',$id)->orderBy('id_keranjang_belanja','desc');

        }else{
            $keranjang_belanjaan = KeranjangBelanja::select()->where('id_pelanggan', Auth::user()->id)->where('id_produk',$id)->orderBy('id_keranjang_belanja','desc');  
        }

            $data_keranjang = $keranjang_belanjaan->first();
            $jumlah_update = $data_keranjang->jumlah_produk + 1;
            $subtotal_update = $data_keranjang->harga_produk * $jumlah_update;
            $keranjang_belanjaan->update(['jumlah_produk' => $data_keranjang->jumlah_produk + 1,'subtotal'=> $subtotal_update]);

            return response()->json($keranjang_belanjaan);
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
        $KeranjangBelanja = KeranjangBelanja::destroy($id);
        return response(200);
    }
}
