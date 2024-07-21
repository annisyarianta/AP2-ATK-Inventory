<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class keluarga extends Model
{
    protected $table = 'keluarga';
    protected $fillable = ['barang_id', 'jumlahkeluar', 'tanggalkeluar', 'unit_id'];

    public function barang()
    {
        return $this->belongsTo(barang::class);
    }

    public function unit()
    {
        return $this->belongsTo(unit::class);
    }
}
