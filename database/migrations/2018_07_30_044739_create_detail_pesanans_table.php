<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pesanan');
            $table->integer('id_produk');
            $table->integer('pelanggan_id');
            $table->float('jumlah_produk',100,2)->default(0.00);
            $table->float('harga_produk',100,2)->default(0.00);
            $table->float('potongan',100,2)->default(0.00)->nullable();
            $table->float('subtotal',100,2)->default(0.00);
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
        Schema::dropIfExists('detail_pesanans');
    }
}
