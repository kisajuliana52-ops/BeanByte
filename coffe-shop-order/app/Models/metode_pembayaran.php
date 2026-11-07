<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metode_Pembayaran extends Model
{
    protected $table = 'metode_pembayarans';
    protected $primaryKey = 'id_metode';
    public $timestamps = false;

    protected $fillable = [
        'nama_metode',
        'keterangan',
    ];

    public function transaksis()
    {
        return $this->hasMany(
            Transaksi::class,
            'id_metode',
            'id_metode'
        );
    }
}
