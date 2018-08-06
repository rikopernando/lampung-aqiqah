<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'pelanggan_id', 'sumber_informasi', 'catatan', 'kirim_ke_alamat_lain', 'nama_peserta', 'tempat_tanggal_lahir', 'jenis_kelamin', 'nama_ayah', 'nama_ibu', 'tempat_lahir', 'total', 'metode_pembayaran'
    ];
}
