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
            $table->foreignId('user_id')->constrained('user');
            $table->string('no_registrasi');
            $table->string('tgl_registrasi');
            $table->string('qr_code');
            $table->foreignId('medicalcard_id')->constrained('medicalcard')->onDelete('cascade');
            $table->foreignId('poly_id')->constrained('poly')->onDelete('cascade');
            $table->foreignId('attachment_id')->constrained('attachment')->onDelete('cascade');
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
