<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id('id_meja');
            $table->string('nomor_meja');
            $table->integer('kapasitas');
            $table->string('status')->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};