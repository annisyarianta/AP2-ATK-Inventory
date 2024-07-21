<?php

namespace App\Http\Controllers;

use App\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Exports\MasukExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\masukga;

class MasukgaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('tanggalawalmasuk')) {
            $tanggalawal = $request->tanggalawalmasuk;
            $tanggalakhir = $request->tanggalakhirmasuk;
            $barang = barang::all();
            $barangmasuk = masukga::whereBetween('tanggalmasuk', [$tanggalawal, $tanggalakhir])->orderbyDesc('tanggalmasuk')->paginate(20);
        } else {
            $barangmasuk = \App\masukga::orderbyDesc('tanggalmasuk')->paginate(20);
            // $lokasi_barang = \App\lokasi::all();
            $barang = barang::all();
        }
        return view('masukga.index', ['barangmasuk' => $barangmasuk, 'barang' => $barang]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'barang_id' => 'required',
            'jumlahmasuk' => 'required|integer',
            'tanggalmasuk' => 'required'
        ]);

        \App\masukga::create($request->all());
        return redirect('/masukga')->with('sukses', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barangmasuk = \App\masukga::find($id);
        $barang = barang::all();
        //$lokasi_barang = \App\lokasi::all();
        return view('masukga/edit', ['barangmasuk' => $barangmasuk, 'barang' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $barang = \App\masukga::find($id);
        $this->validate($request, [
            'barang_id' => 'required',
            'jumlahmasuk' => 'required|integer',
            'tanggalmasuk' => 'required'
        ]);
        $barang->update($request->all());
        return redirect('/masukga')->with('sukses', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $barang = \App\masukga::find($id);
        $barang->delete();
        return redirect('/masukga')->with('sukses', 'Data berhasil dihapus');
    }

    public function exportExcelmasuk()
    {
        return Excel::download(new MasukExport, 'ATK Masuk.xlsx');
    }

    public function exportPDFmasuk()
    {
        $barangmasuk = masukga::all();
        // $lokasi_barang = \App\lokasi::all();
        $barang = barang::all();
        $pdf = PDF::loadView('exports.masukpdf', ['barangmasuk' => $barangmasuk, 'barang' => $barang]);
        return $pdf->download('ATK masuk.pdf');
    }
}
