<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKirimTempatLainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kirim_tempat_lains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pesanan');
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('company_name')->nullable();
            $table->longText('alamat')->nullable();
            $table->integer('provinsi');
            $table->integer('kabupaten');
            $table->integer('kecamatan');
            $table->integer('kelurahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kirim_tempat_lains');
    }
}
