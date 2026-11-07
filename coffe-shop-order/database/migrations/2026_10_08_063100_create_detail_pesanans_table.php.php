<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detailpesanan');

            $table->foreignId('id_pesanan')
                ->constrained('pesanans', 'id_pesanan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('id_menu')
                ->constrained('menus', 'id_menu')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};