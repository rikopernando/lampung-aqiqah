<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = ['nama_lengkap', 'profesi', 'testimoni', 'foto'];
}
