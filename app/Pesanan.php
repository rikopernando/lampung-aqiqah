<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Indonesia;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'sumber_informasi', 'catatan', 'kirim_ke_alamat_lain', 'nama_peserta', 'tempat_tanggal_lahir', 'jenis_kelamin', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'total', 'metode_pembayaran'
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
}
