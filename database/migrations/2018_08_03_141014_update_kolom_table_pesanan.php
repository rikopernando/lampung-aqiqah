<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKolomTablePesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pesanans', function (Blueprint $table) {
         $table->renameColumn('ttl', 'tempat_tanggal_lahir');
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
          $table->dropColumn('tempat_tanggal_lahir');
      });
    }
}
