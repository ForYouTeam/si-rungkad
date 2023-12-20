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
        Schema::create('poly', function (Blueprint $table) {
            $table->id();
            $table->string('nama' ) ;
            $table->string('ruangan' ) ;
            $table->string('jam_praktek')->comment('cth: 09:00-10:00');
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
        Schema::dropIfExists('poly');
    }
};
