<?php

use Illuminate\Database\Seeder;
use App\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        $produk = new Produk();
        $produk->nama_produk = "Paket Prima";
        $produk->harga_coret = 4000000;
        $produk->harga_jual = 3800000;
        $produk->stok = 1;
        $produk->deskripsi_produk = "Satu ekor Hewan Aqiqah + Masak Sate 180 tusuk + gule 30 porsi + Nasi Box 30 porsi Varian isi Nasi Box : Nasi, Cah Buncis Wortel, krupuk Palembang, Buah pisang, sendok, lembar doa, buku risalah";
        $produk->created_by = "1";
        $produk->updated_by = "1";
        $produk->save();

        // 2
        $produk = new Produk();
        $produk->nama_produk = "Paket Special";
        $produk->harga_coret = 4500000;
        $produk->harga_jual = 4200000;
        $produk->stok = 1;
        $produk->deskripsi_produk = "Satu ekor Hewan Aqiqah + Masak Sate 180 tusuk + gule 30 porsi + Nasi Box 30 porsi Varian isi Nasi Box : Nasi, Cah Buncis Wortel, krupuk Palembang, Buah pisang, sendok, lembar doa, buku risalah";
        $produk->created_by = "1";
        $produk->updated_by = "1";
        $produk->save();

        // 3
        $produk = new Produk();
        $produk->nama_produk = "Paket Premium";
        $produk->harga_coret = 3500000;
        $produk->harga_jual = 3100000;
        $produk->stok = 1;
        $produk->deskripsi_produk = "Satu ekor Hewan Aqiqah + Masak Sate 180 tusuk + gule 30 porsi + Nasi Box 30 porsi Varian isi Nasi Box : Nasi, Cah Buncis Wortel, krupuk Palembang, Buah pisang, sendok, lembar doa, buku risalah";
        $produk->created_by = "1";
        $produk->updated_by = "1";
        $produk->save();
    }
}
