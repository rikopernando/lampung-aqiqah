<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKolomStatusPesananTablePesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesanans', function (Blueprint $table) {
          $table->string('status_pesanan')->nullable()->comment('NULL = Baru dipesan, 0 = Pesanan ditolak/dibatalkan, 1 = Pesanan dikonfirmasi, 2 = Pesanan selesai')->change();
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
          $table->dropColumn('status_pesanan');
      });
    }
}
