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
        Schema::create('registation', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi');
            $table->integer('medicalcard_id');
            $table->integer('poly_id');
            $table->string('tgl_registrasi');
            $table->integer('attachment_id');
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
        Schema::dropIfExists('registation');
    }
};
