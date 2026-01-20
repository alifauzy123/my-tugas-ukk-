<?php

namespace App\Http\Controllers;

use App\Models\MutasiStok;
use App\Models\Produk;
use Illuminate\Http\Request;

class MutasiStokController extends Controller
{
    // OPTIONAL (kalau butuh index sendiri)
    public function index()
    {
        $data = MutasiStok::with('produk')->latest()->get();
        return view('mutasi_stok.index', compact('data'));
    }

    // API untuk ambil riwayat stok berdasarkan produk
    public function getByProduk($id)
    {
        $mutasi = MutasiStok::where('produk_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json($mutasi);
    }

    // Fungsi global untuk mencatat mutasi stok
    public static function catat($produk_id, $jenis, $qty, $keterangan)
    {
        $produk = Produk::find($produk_id);

        if (!$produk) return;

        $stok_sebelum = $produk->stok;

        if ($jenis == 'IN') {
            $produk->stok += $qty;
        } 
        elseif ($jenis == 'OUT') {
            $produk->stok -= $qty;
            if ($produk->stok < 0) $produk->stok = 0;
        } 
        elseif ($jenis == 'ADJUST') {
            $produk->stok = $qty; // qty = stok baru
        }

        $produk->save();

        MutasiStok::create([
            'produk_id'     => $produk_id,
            'jenis_mutasi'  => $jenis,
            'qty_mutasi'    => $qty,
            'stok_sebelum'  => $stok_sebelum,
            'stok_sesudah'  => $produk->stok,
            'keterangan'    => $keterangan,
        ]);
    }
}
