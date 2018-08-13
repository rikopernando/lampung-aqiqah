<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DetailPesanan;
use App\KirimTempatLain;
use App\Bank;
use Indonesia;
use Mail;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'sumber_informasi', 'catatan', 'kirim_ke_alamat_lain', 'nama_peserta', 'tempat_tanggal_lahir', 'jenis_kelamin', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'total', 'metode_pembayaran','status_pesanan'
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

    }
}
