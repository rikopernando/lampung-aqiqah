<?php

use Illuminate\Database\Seeder;
use App\SettingPerusahaan;

class SettingPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingPerusahaan::create([
                'name' => 'Aqiqah Lampung',
                'alamat' => 'Jl. Komarudin Blok B No.1 Rajabasa Raya, Bandar Lampung, Lampung',
                'no_telp' => '081249995599',
                'email' => 'andaglos@gmail.com',
                'logo' => 'rumahaqiqah3.png',
                'katalog' => 'KATALOGPRODUK.pdf',
                'foto_slide_1' => 'banner-sate-crop.jpg',
                'foto_slide_2' => 'banner-web-crop.jpeg',
                'foto_slide_3' => 'banner-web-crop2.jpeg']);
    }
}
