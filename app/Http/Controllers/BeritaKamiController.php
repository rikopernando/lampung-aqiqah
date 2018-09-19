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

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pagination($data,$berita_kami,$url){

        $respons['current_page']   = $berita_kami->currentPage();
        $respons['data']           = $data;
        $respons['first_page_url'] = $berita_kami->firstItem();
        $respons['from']           = 1;
        $respons['last_page']      = $berita_kami->lastPage();
        $respons['last_page_url']  = $berita_kami->lastPage();
        $respons['next_page_url']  = $berita_kami->nextPageUrl();
        $respons['path']           = url($url);
        $respons['per_page']       = $berita_kami->perPage();
        $respons['prev_page_url']  = $berita_kami->previousPageUrl();
        $respons['to']             = $berita_kami->perPage();
        $respons['total']          = $berita_kami->total();

        return $respons;

    }

    
    public function index()
    {
       $berita_kami = BeritaKami::orderBy('created_at','desc')->paginate(1);
        $array_berita = [];
        foreach ($berita_kami as $berita) {
            $array_berita[] = [
                'id' => $berita->id,
                'judul_berita' => $berita->judul_berita,
                'isi_berita' => strip_tags($berita->isi_berita),
            ];
        }
        
      return response()->json([
         'berita_kami' => $this->pagination($array_berita, $berita_kami, '/') 
      ],200);
    }

    public function search(Request $request) {
       $berita_kami = BeritaKami::where(function ($berita_kami) use ($request){
              $berita_kami->orWhere('judul_berita','LIKE','%'. $request->search .'%') 
              ->orWhere('isi_berita','LIKE','%'. $request->search .'%'); 
       })->orderBy('created_at','desc')->paginate(1);

        $array_berita = [];
        foreach ($berita_kami as $berita) {
            $array_berita[] = [
                'id' => $berita->id,
                'judul_berita' => $berita->judul_berita,
                'isi_berita' => strip_tags($berita->isi_berita),
            ];
        }

      return response()->json([
         'berita_kami' => $this->pagination($array_berita, $berita_kami, '/pencarian') 
      ],200);

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
