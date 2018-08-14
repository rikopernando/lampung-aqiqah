<?php

use Illuminate\Database\Seeder;
use App\Testimoni;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 1
      $testimoni = new Testimoni();
      $testimoni->nama_lengkap = "Arsyad Al Hadawi";
      $testimoni->profesi = "PNS";
      $testimoni->testimoni = "Menurut saya Aqiqah Lampung sangat membantu, karena untuk aqiqah, kita tidak perlu lagi repot menyembelih sendiri, semua sudah dilakukan oleh Aqiqah Lampung. Bahkan juga tidak perlu memasak, sudah siap santap.";
      $testimoni->save();

      // 2
      $testimoni = new Testimoni();
      $testimoni->nama_lengkap = "Haryadi";
      $testimoni->profesi = "Karyawan Swasta";
      $testimoni->testimoni = "Kadang bukanya nggak bisa cari kambing sendiri, tapi waktunya terbatas karena kerja. Kemarin cari-cari di google, ketemu Aqiqah Lampung, tinggal telpon, langsung datang kambingnya. Sesuai harapan lah..";
      $testimoni->save();

      // 3
      $testimoni = new Testimoni();
      $testimoni->nama_lengkap = "Yeni Andriyani";
      $testimoni->profesi = "Ibu Rumah Tangga";
      $testimoni->testimoni = "Alhamdulillah… Aqiqah lampung telah membantu kelancaran acara Aqiqah anak kami. Layananya cepat dan ramah. Semoga terus bisa membantu masyarakat untuk menyediakan paket aqiqah yang siap saji.";
      $testimoni->save();
    }
}
