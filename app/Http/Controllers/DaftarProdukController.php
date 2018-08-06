<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;

class DaftarProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function viewProduk() {
        return response(Produk::select()->where('stok', 1)->get());
    }

    public function viewProdukTerbaru(){
       return response(Produk::select()->where('stok', 1)->orderBy('id', 'DESC')->limit(4)->get());
    }

    public function sortProduk($filter) {
        if ($filter == 3) {
          $produk = Produk::select()->where('stok', 1)->orderBy('harga_jual', 'DESC')->get();
        }
        elseif ($filter == 4) {
          $produk = Produk::select()->where('stok', 1)->orderBy('harga_jual', 'ASC')->get();
        }
        elseif ($filter == 5) {
          $produk = Produk::select()->where('stok', 1)->orderBy('id', 'DESC')->get();
        }else{
          $produk = Produk::select()->where('stok', 1)->get();
        }

        return response($produk);
    }

    public function detailProduk($id_produk){
       $dataDetailProduk = Produk::select()->where('stok', 1)->where('id',$id_produk)->orderBy('id', 'DESC')->limit(4)->first();
       $respons['nama_produk'] = title_case($dataDetailProduk->nama_produk);
       $respons['foto'] = $dataDetailProduk->foto;
       $respons['harga_coret'] = $dataDetailProduk->harga_coret;
       $respons['harga_jual'] = $dataDetailProduk->harga_jual;
       $respons['deskripsi_produk'] = $dataDetailProduk->deskripsi_produk;
       $respons['id'] = $dataDetailProduk->id;
       return response()->json($respons);
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
