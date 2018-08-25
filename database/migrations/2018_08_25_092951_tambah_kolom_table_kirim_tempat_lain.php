<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKolomTableKirimTempatLain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('kirim_tempat_lains', function (Blueprint $table) {
          $table->string('no_telp')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('kirim_tempat_lains', function (Blueprint $table) {
          $table->dropColumn('no_telp');
      });
    }
}
