<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanOrder extends Model
{
    protected $fillable = [
    	'id_pelanggan', 'id_pesanan'
    ];
}
