<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'mejas';
    protected $primaryKey = 'id_meja';
    public $timestamps = false;

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
    ];

    public function pesanans()
    {
        return $this->hasMany(
            Pesanan::class,
            'id_meja',
            'id_meja'
        );
    }
}
