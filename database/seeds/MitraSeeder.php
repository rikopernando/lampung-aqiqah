<?php

use Illuminate\Database\Seeder;
use App\Mitra;

class MitraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mitra = new Mitra();
      $mitra->nama_mitra = "Rajabasa";
      $mitra->no_telp = "081249995599";
      $mitra->alamat = "Jl. Komarudin Blok B No.1 Rajabasa Raya, Bandar Lampung, Lampung";
      $mitra->save();

      $mitra = new Mitra();
      $mitra->nama_mitra = "Kemiling";
      $mitra->no_telp = "085289985899";
      $mitra->alamat = "Jl. Pramuka, Sentra Bisnis Terminal Kemiling Blok R3 No.7, Sumber Rejo, Kemiling, Kota Bandar Lampung, Lampung 35153";
      $mitra->save();

      $mitra = new Mitra();
      $mitra->nama_mitra = "Kedaton";
      $mitra->no_telp = "081246996529";
      $mitra->alamat = "Jl. Pahlawan, No. 103, Surabaya, Kedaton, Kota Bandar Lampung, Lampung 35153";
      $mitra->save();
    }
}
