<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KirimTempatLain extends Model
{
    protected $fillable = [
        'id_pesanan', 'nama_depan', 'nama_belakang', 'company_name', 'alamat', 'alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'
    ];
}
