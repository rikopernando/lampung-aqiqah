<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKodeUnikKePesanans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pesanans', function (Blueprint $table) {
          $table->integer('kode_unik')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('setting_perusahaans', function (Blueprint $table) {
          $table->dropColumn('kode_unik');
      });
    }
}
