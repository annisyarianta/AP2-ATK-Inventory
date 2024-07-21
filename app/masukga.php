<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masukga extends Model
{
    protected $table = 'masukga';
    protected $fillable = ['barang_id', 'jumlahmasuk', 'tanggalmasuk'];

    public function barang()
    {
        return $this->belongsTo(barang::class);
    }
}
