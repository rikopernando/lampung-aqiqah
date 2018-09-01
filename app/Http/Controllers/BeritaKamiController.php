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
          $berita = BeritaKami::select()->orderBy('created_at','desc');

          $data_berita = $berita->get();
          $count_berita = $berita->count();

        $respons['data_berita'] = $data_berita;
        $respons['count_berita'] = $count_berita;


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
        $this->validate($request, [
            'judul_berita'  => 'required|max:300',
            'isi_berita'     => 'required',
            'foto'          => 'image|max:3072',
        ]);

        $insert_berita = BeritaKami::create([
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
              $image_resize->fit(600,300);
              $image_resize->save(public_path('image_berita/' . $filename));
              $insert_berita->foto = $filename;
              // menyimpan field foto di table barangs  dengan filename yang baru dibuat
              $insert_berita->save();
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
        return response(BeritaKami::whereId($id)->first());
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
        $this->validate($request, [
            'judul_berita'  => 'required|max:300',
            'isi_berita'     => 'required',
            'foto'          => 'image|max:3072',
        ]);

      $update_berita = BeritaKami::find($request->id);
      $update_berita->update([
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
            $image_resize->fit(600,300);
            $image_resize->save(public_path('image_berita/' . $filename));
            $update_berita->foto = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $update_berita->save();
          }
      }

      $update_berita->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $berita = BeritaKami::destroy($id);
          return response(200);
    }
}
