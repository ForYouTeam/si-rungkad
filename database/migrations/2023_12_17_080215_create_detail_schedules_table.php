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
        Schema::create('detail_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId ('schedule_id' )->constrained('schedule')->onDelete('cascade');
            $table->foreignId ('poly_id' )->constrained('poly')->onDelete('cascade');
            $table->time ('start_time' );
            $table->time ('end_time' );
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
        Schema::dropIfExists('detail_schedule');
    }
};
