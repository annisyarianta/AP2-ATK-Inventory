<?php

namespace App\Http\Controllers;

use App\barang;
use Illuminate\Http\Request;
use App\masukga;
use App\keluarga;

class AtkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('cari')) {
            $inventory_barang = barang::where("namabarang", "LIKE", "%" . $request->cari . "%")->orWhere("kodebarang", "LIKE", "%" . $request->cari . "%")->orderBy('namabarang')->paginate();
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else {
            $inventory_barang = barang::orderBy('namabarang')->paginate(20);
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
        }
        // $lokasi_barang = \App\lokasi::all();
        return view('atk.index', ['inventory_barang' => $inventory_barang, 'barangmasuk' => $barangmasuk, 'barangkeluar' => $barangkeluar]);
    }
}
