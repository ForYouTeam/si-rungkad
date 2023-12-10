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
        Schema::create('visithistory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profile');
            $table->foreignId('regis_id')->constrained('registation');
            $table->date('tgl_kunjungan');
            $table->string('waktu_kunjungan');
            $table->string('keterangan');
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
        Schema::dropIfExists('visithistory');
    }
};
