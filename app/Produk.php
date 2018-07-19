<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;

class Produk extends Model
{
  protected $fillable = ['nama_produk', 'harga_coret', 'harga_jual', 'stok', 'deskripsi_produk'];
}
