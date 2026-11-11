<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');

            $table->foreignId('id_pesanan')
                ->constrained('pesanans', 'id_pesanan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_metode')
                ->constrained('metode_pembayarans', 'id_metode')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->dateTime('tanggal_transaksi');
            $table->decimal('total_bayar', 12, 2);
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status_transaksi')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};