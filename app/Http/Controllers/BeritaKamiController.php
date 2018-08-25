<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BeritaKami;
use Intervention\Image\ImageManagerStatic as Image;

class BeritaKamiController extends Controller
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

        public function view() {
        return response(BeritaKami::select()->get());
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
            'judul_berita'  => 'required|max:300',
            'isi_berita'     => 'required',
            'foto'          => 'image|max:3072',
        ]);

        $insert_testimoni = BeritaKami::create([
            'judul_berita' => strtolower($request->judul_berita),
            'isi_berita'      => $request->isi_berita,
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
              $image_resize->fit(2100, 370);
              $image_resize->save(public_path('image_berita/' . $filename));
              $insert_testimoni->foto = $filename;
              // menyimpan field foto di table barangs  dengan filename yang baru dibuat
              $insert_testimoni->save();
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
