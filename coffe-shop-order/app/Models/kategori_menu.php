<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori_Menu extends Model
{
    protected $table = 'kategori_menus';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function menus()
    {
        return $this->hasMany(
            Menu::class,
            'id_kategori',
            'id_kategori'
        );
    }
}
