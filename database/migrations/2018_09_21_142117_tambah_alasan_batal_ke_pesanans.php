<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahAlasanBatalKePesanans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pesanans', function (Blueprint $table) {
          $table->text('alasan_batal')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('pesanans', function (Blueprint $table) {
          $table->dropColumn('alasan_batal');
      });
    }
}
