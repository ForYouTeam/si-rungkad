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
        Schema::create('medicalcard', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm');
            $table->foreignId('user_id')->constrained('user');
            $table->foreignId('profile_id')->constrained('profile')->onDelete('cascade');
            $table->string('barcode');
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
        Schema::dropIfExists('medicalcard');
    }
};
