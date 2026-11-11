<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Pesanan extends Model
{
    protected $table = 'detail_pesanans';
    protected $primaryKey = 'id_detailpesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'catatan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function menu()
    {
        return $this->belongsTo(
            Menu::class,
            'id_menu',
            'id_menu'
        );
    }
}
