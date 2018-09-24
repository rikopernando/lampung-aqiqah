<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingPerusahaan;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class SettingPerusahaanController extends Controller
{
    public function view() {
		return response()->json(SettingPerusahaan::select()->first());
	}

	public function ubahSetting(Request $request) {
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

	    $setting_perusahaan = SettingPerusahaan::find(1);
        $setting_perusahaan->update([
			'name' => $request->name,
			'no_telp' => $request->no_telp,
			'alamat' => $request->alamat,
			'email' => $request->email
        ]);

        if ($request->hasFile('katalog')) {

            $katalog = $request->file('katalog');

            $filename = $this->uploadFile($katalog,'katalog',$setting_perusahaan->katalog);

            $setting_perusahaan->katalog = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $setting_perusahaan->save();
        }

        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');

            $filename = $this->uploadFile($logo,'logo',$setting_perusahaan->logo);

            $setting_perusahaan->logo = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $setting_perusahaan->save();
        }

        if ($request->hasFile('foto_slide_1')) {

            $foto_slide_1 = $request->file('foto_slide_1');

            $filename = $this->uploadFile($foto_slide_1,'slide',$setting_perusahaan->foto_slide_1);

            $setting_perusahaan->foto_slide_1 = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $setting_perusahaan->save();
        }

        if ($request->hasFile('foto_slide_2')) {

            $foto_slide_2 = $request->file('foto_slide_2');

            $filename = $this->uploadFile($foto_slide_2,'slide',$setting_perusahaan->foto_slide_2);

            $setting_perusahaan->foto_slide_2 = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $setting_perusahaan->save();
        }

        if ($request->hasFile('foto_slide_3')) {

            $foto_slide_3 = $request->file('foto_slide_3');

            $filename = $this->uploadFile($foto_slide_3,'slide',$setting_perusahaan->foto_slide_3);

            $setting_perusahaan->foto_slide_3 = $filename;
            // menyimpan field foto di table barangs  dengan filename yang baru dibuat
            $setting_perusahaan->save();
        }
            
        $setting_perusahaan->save();

        return response()->json([
            'message' => 'Success',
            'data' => $setting_perusahaan
        ]);
	}

	public function uploadFile($file,$type,$old_file){

      	if (is_array($file) || is_object($file)) {
            // Mengambil file yang diupload
            $uploaded_foto = $file;
            // mengambil extension file
            $extension = $uploaded_foto->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename     = str_random(40) . '.' . $extension;

            switch ($type):
                case 'logo':
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(271,54);
                    $image_resize->save(public_path('images_logo/' . $filename));
                    $this->deleteFile($old_file, 'images_logo');
                break;
                case 'slide':
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(1366,293);
                    $image_resize->save(public_path('images_slide/' . $filename));
                    $this->deleteFile($old_file, 'images_slide');
                break;
                case 'katalog':
                    $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'katalog';
                    $uploaded_foto->move($destinationPath, $filename);
                    $this->deleteFile($old_file, 'katalog');
                break;
            endswitch;
            
            return $filename;
      	}
    }

    public function deleteFile($old_file,$path) {

        if($old_file) {
            $filepath = public_path() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $old_file;
            try {
              File::delete($filepath);
            } catch (FileNotFoundException $e){
               // File sudah tidak ada
            }
        }
    }
}
