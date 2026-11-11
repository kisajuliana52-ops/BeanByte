<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $primaryKey = 'id_transaksi';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_metode',
        'tanggal_transaksi',
        'total_bayar',
        'bukti_pembayaran',
        'status_transaksi',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(
            Metode_Pembayaran::class,
            'id_metode',
            'id_metode'
        );
    }
}
