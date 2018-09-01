<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingPerusahaan extends Model
{
    protected $fillable = [
        'name', 'email', 'alamat', 'no_telp', 'katalog','logo','foto_slide_1','foto_slide_2','foto_slide_3'
    ];
}
