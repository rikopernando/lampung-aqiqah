<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahPhotoKeSettingPerusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('setting_perusahaans', function (Blueprint $table) {
          $table->string('logo')->nullable();
          $table->string('foto_slide_1')->nullable();
          $table->string('foto_slide_2')->nullable();
          $table->string('foto_slide_3')->nullable();
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
          $table->dropColumn('logo');
          $table->dropColumn('foto_slide_1');
          $table->dropColumn('foto_slide_2');
          $table->dropColumn('foto_slide_3');
      });
    }
}
