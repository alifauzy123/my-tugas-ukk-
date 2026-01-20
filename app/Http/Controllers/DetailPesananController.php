<?php

// app/Http/Controllers/DetailPesananController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;

class DetailPesananController extends Controller
{
    public function index()
    {
        $detail = DetailPesanan::with(['pesanan', 'produk'])->orderBy('id')->get();
        return view('detail_pesanan.index', compact('detail'));
    }

    public function create()
    {
        $latest = DetailPesanan::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $kode = 'DTL' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $pesanan = \App\Models\Pesanan::all();
        $produk = \App\Models\Produk::all();

        return view('detail_pesanan.create', compact('kode', 'pesanan', 'produk'));
    }


public function store(Request $request)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanan,id',
        'produk_id' => 'required|exists:produk,id',
        'qty' => 'required|numeric|min:1',
        'harga' => 'required|numeric|min:0',
        'diskon' => 'nullable|numeric|min:0',
    ]);

    // Ambil produk
    $produk = Produk::findOrFail($request->produk_id);

    // Cek apakah stok cukup
    if ($produk->stok < $request->qty) {
        return back()->with('error', 'Stok produk tidak mencukupi.');
    }

    // Generate kode otomatis
    $latest = DetailPesanan::latest('id')->first();
    $nextId = $latest ? $latest->id + 1 : 1;
    $kode = 'DPSN' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    // Hitung subtotal
    $qty = $request->qty;
    $harga = $request->harga;
    $diskon = $request->diskon ?? 0;
    $subtotal = ($qty * $harga) - $diskon;

    // Simpan detail pesanan
    DetailPesanan::create([
        'kode_detail_pesanan' => $kode,
        'pesanan_id' => $request->pesanan_id,
        'produk_id' => $request->produk_id,
        'qty' => $qty,
        'harga' => $harga,
        'diskon' => $diskon,
        'subtotal' => $subtotal,
    ]);

    // Kurangi stok produk
    $produk->stok -= $qty;
    $produk->save();

    return redirect()->route('detail_pesanan.index')->with('success', 'Detail pesanan berhasil disimpan & stok diperbarui.');
}


public function edit($id)
{
    $detail = DetailPesanan::findOrFail($id);
    $pesanan = Pesanan::all();
    $produk = Produk::all();
    return view('detail_pesanan.edit', compact('detail', 'pesanan', 'produk'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanan,id',
        'produk_id' => 'required|exists:produk,id',
        'qty' => 'required|numeric|min:1',
        'harga' => 'required|numeric|min:0',
        'diskon' => 'nullable|numeric|min:0',
    ]);

    $detail = DetailPesanan::findOrFail($id);
    $subtotal = ($request->qty * $request->harga) - ($request->diskon ?? 0);

    $detail->update([
        'pesanan_id' => $request->pesanan_id,
        'produk_id' => $request->produk_id,
        'qty' => $request->qty,
        'harga' => $request->harga,
        'diskon' => $request->diskon,
        'subtotal' => $subtotal,
    ]);

    return redirect()->route('detail_pesanan.index')->with('success', 'Detail pesanan berhasil diperbarui.');
}

public function show($id)
{
    $detail = DetailPesanan::with(['pesanan', 'produk'])->findOrFail($id);
    return view('detail_pesanan.show', compact('detail'));
}

public function destroy($id)
{
    $detail = DetailPesanan::findOrFail($id);

    // Ambil produk yang terkait
    $produk = Produk::find($detail->produk_id);

    // Kembalikan stok jika produk ditemukan
    if ($produk) {
        $produk->stok += $detail->qty;
        $produk->save();
    }

    // Hapus detail pesanan
    $detail->delete();

    return redirect()->route('detail_pesanan.index')->with('success', 'Detail pesanan berhasil dihapus dan stok dikembalikan.');
}



}
