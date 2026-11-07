<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');

            $table->foreignId('id_pelanggan')
                ->constrained('pelanggans', 'id_pelanggan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_meja')
                ->constrained('mejas', 'id_meja')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->dateTime('tanggal_pesanan');
            $table->decimal('total_harga', 12, 2);

            $table->string('status')->default('menunggu');

            // mengikuti ERD yang kamu kirim
            $table->integer('stok')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};