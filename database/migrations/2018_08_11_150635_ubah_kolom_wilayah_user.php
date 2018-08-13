<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UbahKolomWilayahUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->string('provinsi')->nullable()->change();
          $table->string('kabupaten')->nullable()->change();
          $table->string('kecamatan')->nullable()->change();
          $table->string('kelurahan')->nullable()->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('provinsi');
          $table->dropColumn('kabupaten');
          $table->dropColumn('kecamatan');
          $table->dropColumn('kelurahan');
      });
    }
}
