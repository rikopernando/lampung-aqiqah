<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mitra = new Bank();
      $mitra->nama_bank = "BNI Syariah";
      $mitra->atas_nama = "Aqiqah Lampung";
      $mitra->no_rek = "214515815";
      $mitra->default = "1";
      $mitra->save();
      
      $mitra = new Bank();
      $mitra->nama_bank = "BCA Syariah";
      $mitra->atas_nama = "Aqiqah Lampung";
      $mitra->no_rek = "101023989328";
      $mitra->default = "0";
      $mitra->save();
    }
}
