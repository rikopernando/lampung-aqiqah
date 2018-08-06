<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PesananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
          'nama_pemesan' => 'required',
          'alamat' => 'required',
          'provinsi'  => 'required',
          'kabupaten'  => 'required',
          'kecamatan'  => 'required',
          'kelurahan'  => 'required',
          'handphone'  => 'required',
          'sumber_informasi' => 'required',
          'nama_peserta' => 'required',
          'tempat_tanggal_lahir' => 'required',
          'jenis_kelamin_peserta' => 'required',
          'nama_ayah' => 'required',
          'nama_ibu' => 'required',
        ];

        if(Auth::check()) {
          $rules['email'] = 'required|string|email|max:255';
        }else{
          $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        if(request('kirim_ke_alamat_lain')){
          $rules['kirim_tempat_lain.nama_depan' =>  'required',
          $rules['kirim_tempat_lain.nama_belakang' =>  'required',
          $rules['kirim_tempat_lain.company_name' =>  'required',
          $rules['kirim_tempat_lain.alamat' =>  'required',
          $rules['kirim_tempat_lain.provinsi' =>  'required',
          $rules['kirim_tempat_lain.kabupaten' =>  'required',
          $rules['kirim_tempat_lain.kecamatan' =>  'required',
          $rules['kirim_tempat_lain.kelurahan' =>  'required',
        }

        return $rules;
    }
}
