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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nik');
            $table->string('nama');
            $table->string('alamat');
            $table->string('jk');
            $table->string('agama');
            $table->boolean('status_nikah');
            $table->string('pekerjaan');
            $table->string('kewarganegaraan');
            $table->boolean('verified');
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
        Schema::dropIfExists('profile');
    }
};
