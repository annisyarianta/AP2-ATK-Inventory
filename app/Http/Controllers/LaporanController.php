<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Exports\LaporanExport;
use App\keluarga;
use App\masukga;
use App\barang;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Http\Request;


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('cari')) {
            $inventory_barang = barang::where("namabarang", "LIKE", "%" . $request->cari . "%")->orderBy('namabarang')->paginate();
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else {
            $inventory_barang = barang::orderBy('namabarang')->paginate(20);
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
        }
        // $lokasi_barang = \App\lokasi::all();
        return view('laporan.index', ['inventory_barang' => $inventory_barang, 'barangmasuk' => $barangmasuk, 'barangkeluar' => $barangkeluar]);
    }

    public function excel(Request $request)
    {
        if ($request->has('cari')) {
            $inventory_barang = barang::where("namabarang", "LIKE", "%" . $request->cari . "%")->orderBy('namabarang')->paginate();
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else {
            $inventory_barang = barang::orderBy('namabarang')->paginate(20);
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
        }
        // $lokasi_barang = \App\lokasi::all();
        return view('laporan.excel', ['inventory_barang' => $inventory_barang, 'barangmasuk' => $barangmasuk, 'barangkeluar' => $barangkeluar]);
    }

    public function exportExcellaporan(Request $request)
    {
        return Excel::download(new LaporanExport($request->tanggalawal, $request->tanggalakhir, $request->jenislaporan), 'ATK Laporan.xlsx');
    }

    public function pdf(Request $request)
    {
        if ($request->has('cari')) {
            $inventory_barang = barang::where("namabarang", "LIKE", "%" . $request->cari . "%")->orderBy('namabarang')->paginate();
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else {
            $inventory_barang = barang::orderBy('namabarang')->paginate(20);
            $barangmasuk = masukga::all();
            $barangkeluar = keluarga::all();
        }
        // $lokasi_barang = \App\lokasi::all();
        return view('laporan.pdf', ['inventory_barang' => $inventory_barang, 'barangmasuk' => $barangmasuk, 'barangkeluar' => $barangkeluar]);
    }

    public function exportPDFlaporan(Request $request)
    {
        if ($request->jenislaporan == "barangmasuk") {
            $barang = barang::all();
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            $barangmasuk = masukga::whereBetween('tanggalmasuk', [$tanggalawal, $tanggalakhir])->get();
            $pdf = PDF::loadView('exports.masukpdf', ['barangmasuk' => $barangmasuk, 'barang' => $barang]);
            return $pdf->download('ATK laporan.pdf');
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else if ($request->jenislaporan == "barangkeluar") {
            $barang = barang::all();
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            $barangkeluar = keluarga::whereBetween('tanggalkeluar', [$tanggalawal, $tanggalakhir])->get();
            $pdf = PDF::loadView('exports.keluarpdf', ['barangkeluar' => $barangkeluar, 'barang' => $barang]);
            return $pdf->download('ATK laporan.pdf');
        }
    }

    public function cari(Request $request)
    {
        if ($request->jenislaporan == "barangmasuk") {
            $barang = barang::all();
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            $barangmasuk = masukga::whereBetween('tanggalmasuk', [$tanggalawal, $tanggalakhir])->orderby('tanggalmasuk')->paginate(20);
            return view('masukga.index', ['barang' => $barang, 'barangmasuk' => $barangmasuk]);
            // ->orwhere("gudang", "LIKE", "%" . $request->cari . "%")
        } else if ($request->jenislaporan == "barangkeluar") {
            $barang = barang::all();
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            $barangkeluar = keluarga::whereBetween('tanggalkeluar', [$tanggalawal, $tanggalakhir])->orderby('tanggalkeluar')->paginate(20);
            return view('keluarga.index', ['barang' => $barang, 'barangkeluar' => $barangkeluar]);
        }
        // $lokasi_barang = \App\lokasi::all();

    }
}
