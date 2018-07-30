<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class KeranjangBelanja extends Model
{
    //

    protected $fillable   = ['id_produk', 'id_pelanggan','jumlah_produk', 'session_id','harga_produk','subtotal'];
    protected $primaryKey = 'id_keranjang_belanja';
    // relasi ke produk
    public function produk()
    {
        return $this->hasOne('App\Produk', 'id', 'id_produk');
    }
}
