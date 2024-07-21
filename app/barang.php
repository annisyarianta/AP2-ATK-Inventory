<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['namabarang', 'kodebarang', 'gambar'];

    public function masukga()
    {
        return $this->hasMany(masukga::class);
    }

    public function keluarga()
    {
        return $this->hasMany(keluarga::class);
    }

    public function getGambar()
    {
        if (!$this->gambar) {
            return asset('images/Kopi Branti.png');
        }

        return asset('images/' . $this->gambar);
    }
}
