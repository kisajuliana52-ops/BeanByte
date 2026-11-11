<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_menu',
        'harga',
        'gambar',
        'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            Kategori_Menu::class,
            'id_kategori',
            'id_kategori'
        );
    }

    public function detailPesanans()
    {
        return $this->hasMany(
            Detail_Pesanan::class,
            'id_menu',
            'id_menu'
        );
    }
}
