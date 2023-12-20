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
        Schema::create('historie', function (Blueprint $table) {
            $table->id();
            $table->foreignId ('visit_id' )->constrained('visit')->onDelete('cascade');
            $table->text('ket');
            $table->date('tgl');
            $table->boolean('visit_sugest');
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
        Schema::dropIfExists('historie');
    }
};
