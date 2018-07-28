<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKolomTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->longText('alamat')->nullable();
          $table->string('no_telp')->nullable();
          $table->integer('provinsi')->nullable();
          $table->integer('kabupaten')->nullable();
          $table->integer('kecamatan')->nullable();
          $table->integer('kelurahan')->nullable();
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
          $table->dropColumn('alamat');
          $table->dropColumn('no_telp');
          $table->dropColumn('provinsi');
          $table->dropColumn('kabupaten');
          $table->dropColumn('kecamatan');
          $table->dropColumn('kelurahan');
      });
    }
}
