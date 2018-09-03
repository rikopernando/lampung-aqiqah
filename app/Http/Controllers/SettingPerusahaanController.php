<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingPerusahaan;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class SettingPerusahaanController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return response(SettingPerusahaan::select()->first());
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
         return response(SettingPerusahaan::select()->first());
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
    public function update(Request $request,$id)
    {
          $this->validate($request, [
              'name'      => 'required',
              'email'     => 'required|string|email',
              'no_telp'   => 'required',
              'alamat'    => 'required',
              'logo'      => 'image|max:3072',
              'katalog'      => 'mimes:pdf',
              'foto_slide_1'   => 'image|max:3072',
              'foto_slide_2'   => 'image|max:3072',
              'foto_slide_3'   => 'image|max:3072',
          ]);

          $setting_perusahaan = SettingPerusahaan::find($id);
          $setting_perusahaan->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $request->email
          ]);

          if($request->hasFile('katalog')){
              $katalog = $request->file('katalog');

              if (is_array($katalog) || is_object($katalog)) {
                // Mengambil file yang diupload
                $uploaded_katalog = $katalog;
                // mengambil extension file
                $extension = $uploaded_katalog->getClientOriginalExtension();
                // membuat nama file random berikut extension
                $filename     = str_random(40) . '.' . $extension;
                // menyimpan katalog ke folder public/katalog
                $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'katalog';
                // memindahkan file ke folder public/katalog
                $uploaded_katalog->move($destinationPath, $filename);

                $this->deleteFile($setting_perusahaan->katalog, 'katalog');

                $setting_perusahaan->katalog = $filename;
                // menyimpan field foto di table barangs  dengan filename yang baru dibuat
                $setting_perusahaan->save();
              }
          }

          if ($request->hasFile('logo')) {
              $logo = $request->file('logo');

              if (is_array($logo) || is_object($logo)) {
                // Mengambil file yang diupload
                $uploaded_logo = $logo;
                // mengambil extension file
                $extension = $uploaded_logo->getClientOriginalExtension();
                // membuat nama file random berikut extension
                $filename     = str_random(40) . '.' . $extension;
                $image_resize = Image::make($logo->getRealPath());
                $image_resize->save(public_path('images_logo/' . $filename));

                $this->deleteFile($setting_perusahaan->logo, 'images_logo');

                $setting_perusahaan->logo = $filename;
                // menyimpan field foto di table barangs  dengan filename yang baru dibuat
                $setting_perusahaan->save();
              }
          }

          if ($request->hasFile('foto_slide_1')) {
              $foto_slide_1 = $request->file('foto_slide_1');

              if (is_array($foto_slide_1) || is_object($foto_slide_1)) {
                // Mengambil file yang diupload
                $uploaded_foto_slide_1 = $foto_slide_1;
                // mengambil extension file
                $extension = $uploaded_foto_slide_1->getClientOriginalExtension();
                // membuat nama file random berikut extension
                $filename     = str_random(40) . '.' . $extension;
                $image_resize = Image::make($foto_slide_1->getRealPath());
                $image_resize->fit(1366,293);
                $image_resize->save(public_path('images_slide/' . $filename));

                $this->deleteFile($setting_perusahaan->foto_slide_1, 'images_slide');

                $setting_perusahaan->foto_slide_1 = $filename;
                // menyimpan field foto di table barangs  dengan filename yang baru dibuat
                $setting_perusahaan->save();
              }
          }

          if ($request->hasFile('foto_slide_2')) {
              $foto_slide_2 = $request->file('foto_slide_2');

              if (is_array($foto_slide_2) || is_object($foto_slide_2)) {
                // Mengambil file yang diupload
                $uploaded_foto_slide_2 = $foto_slide_2;
                // mengambil extension file
                $extension = $uploaded_foto_slide_2->getClientOriginalExtension();
                // membuat nama file random berikut extension
                $filename     = str_random(40) . '.' . $extension;
                $image_resize = Image::make($foto_slide_2->getRealPath());
                $image_resize->fit(1366,293);
                $image_resize->save(public_path('images_slide/' . $filename));

                $this->deleteFile($setting_perusahaan->foto_slide_2, 'images_slide');

                $setting_perusahaan->foto_slide_2 = $filename;
                // menyimpan field foto di table barangs  dengan filename yang baru dibuat
                $setting_perusahaan->save();
              }
          }

          if ($request->hasFile('foto_slide_3')) {
              $foto_slide_3 = $request->file('foto_slide_3');

              if (is_array($foto_slide_3) || is_object($foto_slide_3)) {
                // Mengambil file yang diupload
                $uploaded_foto_slide_3 = $foto_slide_3;
                // mengambil extension file
                $extension = $uploaded_foto_slide_3->getClientOriginalExtension();
                // membuat nama file random berikut extension
                $filename     = str_random(40) . '.' . $extension;
                $image_resize = Image::make($foto_slide_3->getRealPath());
                $image_resize->fit(1366,293);
                $image_resize->save(public_path('images_slide/' . $filename));
                
                $this->deleteFile($setting_perusahaan->foto_slide_3, 'images_slide');

                $setting_perusahaan->foto_slide_3 = $filename;
                // menyimpan field foto di table barangs  dengan filename yang baru dibuat
                $setting_perusahaan->save();
              }
          }
            
          $setting_perusahaan->save();

          return response()->json([
                    'message' => 'Success',
                    'data' => $setting_perusahaan
                 ]);

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

    public function deleteFile($old_file,$path) {

        if($old_file){
            $filepath = public_path() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $old_file;
            try {
              File::delete($filepath);
            } catch (FileNotFoundException $e){
               // File sudah tidak ada
            }
        }
    }
}
