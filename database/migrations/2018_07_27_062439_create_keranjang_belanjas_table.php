<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeranjangBelanjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang_belanjas', function (Blueprint $table) {
            $table->increments('id_keranjang_belanja');
            $table->integer('id_produk');
            $table->integer('id_pelanggan')->nullable();
            $table->integer('jumlah_produk');
            $table->bigInteger('harga_produk'); 
            $table->bigInteger('subtotal'); 
            $table->string('session_id', 100)->nullable();
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
        Schema::dropIfExists('keranjang_belanjas');
    }
}
