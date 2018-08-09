<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKolomTampilProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('produks', function (Blueprint $table) {
          $table->integer('tampil_produk')->default(2)->comment = "1 = true , 2 = false";
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('produks', function (Blueprint $table) {
          $table->dropColumn('tampil_produk');
      });
    }
}
