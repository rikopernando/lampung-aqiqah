<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use Intervention\Image\ImageManagerStatic as Image;

class ProdukController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view() {
        return response(Produk::select()->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      $this->validate($request, [
          'nama_produk' => 'required|max:300',
          'harga_coret' => 'required|numeric|digits_between:1,11',
          'harga_jual'  => 'required|numeric|digits_between:1,11',
          'foto'        => 'image|max:3072',
      ]);

      $insert_produk = Produk::create([
          'nama_produk'       => strtolower($request->nama_produk),
          'harga_coret'       => $request->harga_coret,
          'harga_jual'        => $request->harga_jual,
          'stok'              => $request->stok == "true" ? 1 : 2,
          'deskripsi_produk'  => $request->deskripsi_produk
      ]);

      if ($request->hasFile('foto')) {
        $foto = $request->file('foto');

          if (is_array($foto) || is_object($foto)) {
            // Mengambil file yang diupload
            $uploaded_foto = $foto;
            // mengambil extension file
            $extension = $uploaded_foto->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename     = str_random(40) . '.' . $extension;
            $image_resize = Image::make($foto->getRealPath());
            $image_resize->fit(300);
            $image_resize->save(public_path('image_produks/' . $filename));
            $insert_produk->foto = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $insert_produk->save();
          }
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Produk::whereId($id)->first());
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
    public function update(Request $request)
    {
      $this->validate($request, [
          'nama_produk' => 'required|max:300',
          'harga_coret' => 'required|numeric|digits_between:1,11',
          'harga_jual'  => 'required|numeric|digits_between:1,11',
      ]);
      $update_produk = Produk::find($request->id);
      $update_produk->update([
        'nama_produk'       => strtolower($request->nama_produk),
        'harga_coret'       => $request->harga_coret,
        'harga_jual'        => $request->harga_jual,
        'stok'              => $request->stok == "true" ? 1 : 2,
        'deskripsi_produk'  => $request->deskripsi_produk,
      ]);

      if ($request->hasFile('foto')) {
        $foto = $request->file('foto');

          if (is_array($foto) || is_object($foto)) {
            // Mengambil file yang diupload
            $uploaded_foto = $foto;
            // mengambil extension file
            $extension = $uploaded_foto->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename     = str_random(40) . '.' . $extension;
            $image_resize = Image::make($foto->getRealPath());
            $image_resize->fit(300);
            $image_resize->save(public_path('image_produks/' . $filename));
            $update_produk->foto = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $update_produk->save();
          }
      }

      $update_produk->save();
    }

    public function updateTampilProduk($id, $boolean) {
      $update_produk = Produk::find($id);
      $update_produk->update([
        'tampil_produk'  => $boolean == "true" ? 1 : 2,
      ]);
      $update_produk->save();
    }

    public function jumlahTampil() {
      return response(Produk::where('tampil_produk', 1)->count());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $produk = Produk::destroy($id);
      return response(200);
    }
}
