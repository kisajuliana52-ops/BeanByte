<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'jenis_pelanggan',
    ];

    public function pesanans()
    {
        return $this->hasMany(
            Pesanan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }
}
