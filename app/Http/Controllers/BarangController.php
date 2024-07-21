<?php

namespace App\Http\Controllers;

use App\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('carimasterdata')) {
            $inventory_barang = barang::where("namabarang", "LIKE", "%" . $request->carimasterdata . "%")->orWhere("kodebarang", "LIKE", "%" . $request->carimasterdata . "%")->orderBy('namabarang')->paginate();
        } else {
            $inventory_barang = barang::orderBy('namabarang')->paginate(20);
        }
        return view('barang.index', ['inventory_barang' => $inventory_barang]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'namabarang' => 'required|unique:barang',
            'kodebarang' => 'required|unique:barang',
            'gambar' => 'mimes:jpg,jpeg,png'
        ]);

        $barang = barang::create($request->all());
        if ($request->hasFile('gambar')) {
            $namafile = Str::random(12);
            $request->file('gambar')->move('images/', $namafile);
            $barang->gambar = $namafile;
            $barang->save();
        }
        return redirect('/barang')->with('sukses', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = barang::find($id);
        //$lokasi_barang = \App\lokasi::all();
        return view('barang/edit', ['barang' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $barang = barang::find($id);
        $this->validate($request, [
            'namabarang' => 'required',
            'kodebarang' => 'required',
            'gambar' => 'mimes:jpg,jpeg,png'
        ]);
        $barang->update($request->all());
        if ($request->hasFile('gambar')) {
            $namafile = Str::random(12);
            $request->file('gambar')->move('images/', $namafile);
            $barang->gambar = $namafile;
            $barang->save();
        }
        return redirect('/barang')->with('sukses', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $barang = barang::find($id);
        if ($barang->masukga->all() & $barang->keluarga->all()) {
            return redirect('/barang')->with('gagal', 'Data gagal dihapus, data masih digunakan pada barang masuk/keluar!');
        } else {
            $barang->delete();
            return redirect('/barang')->with('sukses', 'Data berhasil dihapus');
        }
    }

    // public function exportPDF()
    // {
    //     $inventory_barang = \App\inventory::all();
    //     $pdf = PDF::loadView('exports.inventorypdf', ['inventory_barang' => $inventory_barang]);
    //     return $pdf->download('inventory.pdf');
    // }

    // public function exportExcel()
    // {
    //     return Excel::download(new BarangExport, 'inventory.xlsx');
    // }
}
