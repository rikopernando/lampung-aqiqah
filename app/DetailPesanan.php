<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'id_pesanan', 'id_produk', 'pelanggan_id', 'jumlah_produk', 'harga_produk', 'potongan', 'subtotal'
    ];

    public function produk()
    {
        return $this->hasOne('App\Produk', 'id', 'id_produk');
    }
}
