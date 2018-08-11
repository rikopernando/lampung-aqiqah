<?php

namespace App\Http\Controllers;

use Indonesia;
use App\Pesanan;
use App\User;
use App\Role;
use App\DetailPesanan;
use App\KeranjangBelanja;
use App\KirimTempatLain;
use App\Produk;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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

      DB::beginTransaction();

      $this->validationPesanan($request);

      if(Auth::check()){
         $pelanggan_id = Auth::User()->id;
         $keranjang_belanja = KeranjangBelanja::where('id_pelanggan',$pelanggan_id);
      }else{

        $user = User::create([
            'name' => $request->nama_pemesan,
            'email' => $request->email,
            'password' => bcrypt('123456'),
        ]);

        $memberRole = Role::where('name' , 'member')->first();
        $user->attachRole($memberRole);

        $pelanggan_id = $user->id;
        $session_id = $this->getSessionId();
        $keranjang_belanja = KeranjangBelanja::where('session_id',$session_id);
      }

      $update_alamat_user = User::find($pelanggan_id);
      $update_alamat_user->update([
        'provinsi' => $request->provinsi, 'kabupaten' => $request->kabupaten, 'kecamatan' => $request->kecamatan, 'kelurahan' => $request->kelurahan, 'alamat' => $request->alamat, 'no_telp' => $request->handphone
      ]);

      $new_pesanan = Pesanan::create([
        'pelanggan_id' => $pelanggan_id,
        'sumber_informasi' => $request->sumber_informasi,
        'catatan' => $request->catatan,
        'nama_peserta' => $request->nama_peserta,
        'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin_peserta,
        'nama_ayah' => $request->nama_ayah,
        'nama_ibu' => $request->nama_ibu,
        'tempat_lahir' => $request->tempat_lahir,
        'total' => $request->total,
        'metode_pembayaran' => $request->metode_pembayaran
      ]);

      if($request->kirim_ke_alamat_lain){

          $new_kirim_tempat_lain = KirimTempatLain::create([
             'id_pesanan' => $new_pesanan->id,
             'nama_depan' => $request->kirim_tempat_lain['nama_depan'],
             'nama_belakang' => $request->kirim_tempat_lain['nama_belakang'],
             'company_name' => $request->kirim_tempat_lain['company_name'],
             'alamat' => $request->kirim_tempat_lain['alamat'],
             'provinsi' => $request->kirim_tempat_lain['provinsi'],
             'kabupaten' => $request->kirim_tempat_lain['kabupaten'],
             'kecamatan' => $request->kirim_tempat_lain['kecamatan'],
             'kelurahan' => $request->kirim_tempat_lain['kelurahan']
          ]);

      }


      foreach($keranjang_belanja->get() as $data) {
        $new_detail_pesanan = DetailPesanan::create([
          'id_pesanan' => $new_pesanan->id, 'id_produk' => $data->id_produk, 'pelanggan_id' => $pelanggan_id, 'jumlah_produk' => $data->jumlah_produk, 'harga_produk' => $data->harga_produk, 'potongan' => $data->potongan, 'subtotal' => $data->subtotal
        ]);            
      }

      $keranjang_belanja->delete();

      $new_pesanan->pesananDiterima();

      DB::commit();

      return $new_pesanan->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pesanan = Pesanan::with('pelanggan')->where('id',$id);

        if($pesanan->count() > 0){
            
            $pesanan = $pesanan->first();
            $detail_pesanan = DetailPesanan::with('produk')->where('id_pesanan',$pesanan->id)->get();
            $kirim_tempat_lain = KirimTempatLain::where('id_pesanan',$pesanan->id);
            
            $data_pesanan = [
                ['header' => 'Nomor Order', 'content' => '#'.$pesanan->id], 
                ['header' => 'Tanggal', 'content' => $pesanan->Tanggal], 
                ['header' => 'Total', 'content' => $pesanan->total], 
                ['header' => 'Pembayaran', 'content' => $pesanan->metode_pembayaran], 
            ];

            if($pesanan->metode_pembayaran == 'Transfer Bank'){
              array_push($data_pesanan,
                ['header' => 'Bank', 'content' => 'BNI SYARIAH'], 
                ['header' => 'Nomor Rekening', 'content' => '3737-8899-21'], 
                ['header' => 'Atas Nama', 'content' => 'IWAN SETIAWAN']);
            }

            $pesanan->jenis_kelamin == 1 ? $jenis_kelamin = 'Laki - Laki' : $jenis_kelamin = 'Perempuan';

            $pemesan = [
               ['judul' => 'Nama', 'isi' => $pesanan->pelanggan->name], 
               ['judul' => 'Alamat', 'isi' => $pesanan->pelanggan->alamat], 
               ['judul' => 'Kelurahan', 'isi' => $pesanan->Kelurahan], 
               ['judul' => 'Kecamatan', 'isi' => $pesanan->Kecamatan], 
               ['judul' => 'Kabupaten', 'isi' => $pesanan->Kabupaten], 
               ['judul' => 'Provinsi', 'isi' => $pesanan->Provinsi], 
               ['judul' => 'Sumber Informasi', 'isi' => $pesanan->sumber_informasi], 
               ['judul' => 'Nama Peserta', 'isi' => $pesanan->nama_peserta], 
               ['judul' => 'Tempat, Tanggal Lahir', 'isi' => $pesanan->tempat_tanggal_lahir], 
               ['judul' => 'Jenis Kelamin', 'isi' => $jenis_kelamin], 
               ['judul' => 'Nama Ayah', 'isi' => $pesanan->nama_ayah], 
               ['judul' => 'Nama Ibu', 'isi' => $pesanan->nama_ibu], 
               ['judul' => 'Lahir Di (Nama RSB / Bidan)', 'isi' => $pesanan->tempat_lahir]
            ];

            if($kirim_tempat_lain->count() > 0){

                $alamat_kirim = [
                   ['judul' => 'Nama', 'isi' => $kirim_tempat_lain->first()->nama_depan." ".$kirim_tempat_lain->first()->nama_belakang], 
                   ['judul' => 'Company Name', 'isi' => $kirim_tempat_lain->first()->company_name], 
                   ['judul' => 'Alamat', 'isi' => $kirim_tempat_lain->first()->alamat], 
                   ['judul' => 'Kelurahan', 'isi' => $kirim_tempat_lain->first()->KelurahanKirim], 
                   ['judul' => 'Kecamatan', 'isi' => $kirim_tempat_lain->first()->KecamatanKirim], 
                   ['judul' => 'Kabupaten', 'isi' => $kirim_tempat_lain->first()->KabupatenKirim], 
                   ['judul' => 'Provinsi', 'isi' => $kirim_tempat_lain->first()->ProvinsiKirim], 
                ];
            }else{
                $alamat_kirim = [];
            }

            $response['pesanan'] = $data_pesanan;
            $response['pemesan'] = $pemesan;
            $response['detail_pesanan'] = $detail_pesanan;
            $response['kirim_tempat_lain'] = $alamat_kirim;
            $response['subtotal'] = $pesanan->total;

            return $response; 
        }else{
            return $pesanan->count();
        }
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

    public function provinsi(){
        $provinsi = Indonesia::allProvinces();
        return response()->json($provinsi);
    }

    public function pilih_wilayah($id,$type){

   # Tarik ID_wilayah & tipe_wilayah
        $id_wilayah   = $id;
        $type_wilayah = $type;

        # Buat pilihan "Switch Case" berdasarkan variabel "type" dari dari data yg dikirim
        switch ($type_wilayah):
    # untuk kasus "kabupaten"
        case 'kabupaten':
        $kabupaten = Indonesia::allCities()->where('province_id', $id);
        return response()->json($kabupaten);
        break;
    # untuk kasus "kecamatan"
        case 'kecamatan':
        $kecamatan = Indonesia::allDistricts()->where('city_id', $id);
        return response()->json($kecamatan);
        break;
    # untuk kasus "kelurahan"
        case 'kelurahan':
        $kelurahan = Indonesia::allVillages()->where('district_id', $id);
        return response()->json($kelurahan);
        break;
        # pilihan berakhir
        endswitch;
    }

    public function getSessionId() {
        if(!Session::get('session_id')){
            $session_id    = session()->getId();
        }else{
            $session_id = Session::get('session_id');
        }
        return $session_id;
    }

    public function validationPesanan($request) {

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
          'tempat_lahir' => 'required',
        ];

        if(Auth::check()) {
          $rules['email'] = 'required|string|email|max:255';
        }else{
          $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        if($request->kirim_ke_alamat_lain){
          $rules['kirim_tempat_lain.nama_depan'] =  'required';
          $rules['kirim_tempat_lain.nama_belakang'] =  'required';
          $rules['kirim_tempat_lain.company_name'] = 'required';
          $rules['kirim_tempat_lain.alamat'] = 'required';
          $rules['kirim_tempat_lain.provinsi'] = 'required';
          $rules['kirim_tempat_lain.kabupaten'] = 'required';
          $rules['kirim_tempat_lain.kecamatan'] = 'required';
          $rules['kirim_tempat_lain.kelurahan'] = 'required';
        }

        $this->validate($request,$rules);

    }

    public function history_order() {
        return response(Pesanan::where('pelanggan_id',Auth::User()->id)->get());
    }

    public function detail_order($id) {
        $detail_pesanan = DetailPesanan::with(["produk"])
          ->where("id_pesanan", $id)
          ->where("pelanggan_id", Auth::user()->id)
          ->get();
        return response($detail_pesanan);
    }

}
