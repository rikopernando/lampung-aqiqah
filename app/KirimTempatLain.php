<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Indonesia;

class KirimTempatLain extends Model
{
    protected $fillable = [
        'id_pesanan', 'nama_depan', 'nama_belakang', 'company_name', 'alamat', 'alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'
    ];

    public function getProvinsiKirimAttribute() {
        return Indonesia::findProvince($this->provinsi)->name;
    }

    public function getKabupatenKirimAttribute() {
        return Indonesia::findCity($this->kabupaten)->name;
    }

    public function getKecamatanKirimAttribute() {
        return Indonesia::findDistrict($this->kecamatan)->name;
    }

    public function getKelurahanKirimAttribute() {
        return Indonesia::findVillage($this->kelurahan)->name;
    }

}
