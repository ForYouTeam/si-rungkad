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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('no action');
            $table->string('nip');
            $table->string('nama');
            $table->string('alamat');
            $table->string('jk');
            $table->string('agama');
            $table->string('jurusan');
            $table->foreignId('poly_id')->nullable()->constrained('poly')->onDelete('set null');
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
        Schema::dropIfExists('doctor');
    }
};
