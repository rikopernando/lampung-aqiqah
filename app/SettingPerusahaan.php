<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingPerusahaan extends Model
{
    protected $fillable = [
        'name', 'email', 'alamat', 'no_telp', 'katalog'
    ];
}
