<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimoni;
use Intervention\Image\ImageManagerStatic as Image;

class TestimoniController extends Controller
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
        return response(Testimoni::select()->get());
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
            'nama_lengkap'  => 'required|max:300',
            'profesi'       => 'required|max:300',
            'testimoni'     => 'required',
            'foto'          => 'image|max:3072',
        ]);

        $insert_produk = Testimoni::create([
            'nama_lengkap' => strtolower($request->nama_lengkap),
            'profesi'      => $request->profesi,
            'testimoni'    => $request->testimoni
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
        return response(Testimoni::whereId($id)->first());
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
      $testimoni = Testimoni::destroy($id);
      return response(200);
    }
}
