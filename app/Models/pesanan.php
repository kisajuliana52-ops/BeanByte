<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $primaryKey = 'id_pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_meja',
        'tanggal_pesanan',
        'total_harga',
        'status',
        'stok',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }

    public function meja()
    {
        return $this->belongsTo(
            Meja::class,
            'id_meja',
            'id_meja'
        );
    }

    public function detailPesanans()
    {
        return $this->hasMany(
            Detail_Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function transaksi()
    {
        return $this->hasOne(
            Transaksi::class,
            'id_pesanan',
            'id_pesanan'
        );
    }
}
