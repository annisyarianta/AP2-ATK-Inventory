<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\barang;
use App\keluarga;

class KeluarExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        $barangkeluar = keluarga::all();
        // $lokasi_barang = \App\lokasi::all();
        $barang = barang::all();
        return view('exports.keluarexcel', ['barangkeluar' => $barangkeluar, 'barang' => $barang]);
    }
}
