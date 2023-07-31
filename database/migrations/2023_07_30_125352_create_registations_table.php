<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registations', function (Blueprint $table) {
            $table->id();
            $table->string('no_registarsi');
            $table->integer('id_medical_card');
            $table->integer('id_poly');
            $table->string('tgl_registrasi');
            $table->integer('id_attachment');
            $table->string('qr_code');
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
        Schema::dropIfExists('registations');
    }
};
