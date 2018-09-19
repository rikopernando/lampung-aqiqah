<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DetailPesanan;
use App\KirimTempatLain;
use App\Bank;
use Indonesia;
use App\SettingPerusahaan;
use Mail;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'sumber_informasi', 'catatan', 'kirim_ke_alamat_lain', 'nama_peserta', 'tempat_tanggal_lahir', 'jenis_kelamin', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'total', 'metode_pembayaran','status_pesanan','kode_unik'
    ];

    public function pelanggan()
    {
        return $this->hasOne('App\User', 'id', 'pelanggan_id');
    }

    public function getProvinsiAttribute() {
        return Indonesia::findProvince($this->pelanggan->provinsi)->name;
    }

    public function getKabupatenAttribute() {
        return Indonesia::findCity($this->pelanggan->kabupaten)->name;
    }

    public function getKecamatanAttribute() {
        return Indonesia::findDistrict($this->pelanggan->kecamatan)->name;
    }

    public function getKelurahanAttribute() {
        return Indonesia::findVillage($this->pelanggan->kelurahan)->name;
    }

    public function getTanggalAttribute() {
        $tanggal = date($this->created_at);
        $date = date_create($tanggal);
        $date_terbalik = date_format($date, "Y-m-d");
        return $this->tanggal_indo($date_terbalik);
    }
    
    public function tanggal_indo($tanggal){
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

    public function pesananDiterima(){

        $pesanan = $this;
        $detail_pesanan = DetailPesanan::with('produk')->where('id_pesanan',$pesanan->id)->get();
        $kirim_tempat_lain = KirimTempatLain::where('id_pesanan',$pesanan->id);
        $bank = Bank::where('default',1)->first();

        Mail::send('mails.pesanan_diterima', compact('pesanan','detail_pesanan','kirim_tempat_lain','bank'), function ($message) use ($pesanan) {
              $message->from('verifikasi@andaglos.id','Aqiqah Lampung');
              $message->to($pesanan->pelanggan->email);
              $message->subject('Pesanan Anda Telah Kami Terima');
        });

        $id_pesanan = $pesanan->id;
        $email = SettingPerusahaan::select()->first()->email;

        Mail::send('mails.notifikasi_admin', compact('id_pesanan'), function ($message) use ($email) {
              $message->from('verifikasi@andaglos.id','Aqiqah Lampung');
              $message->to($email);
              $message->subject('Ada Pesanan baru di Aqiqah Lampung');
        });

    }

    public static function kodeUniktransfer(){
        $pesanan = Pesanan::select('id')->orderBy('id','DESC')->limit(1);
        if($pesanan->count() == 0) {
            $id_pesanan = $pesanan->count() + 1;
        }else{
            $id_pesanan = $pesanan->first()->id + 1;
        }
        $kode_unik = $id_pesanan % 1000;
        return $kode_unik;
    }

    public function scopeLaporanOrder($query){
            $query->join('users', 'pesanans.pelanggan_id', '=', 'users.id')
            ->select('users.name as nama_pelanggan', 'pesanans.id as id_pesanan', 'pesanans.created_at as waktu_pesan', 'pesanans.total', 'pesanans.status_pesanan');
            return $query;
    }
}
