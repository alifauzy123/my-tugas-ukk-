<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Menampilkan semua data pembayaran
    public function index()
    {
        $pembayaran = Pembayaran::with('pesanan')->orderBy('id')->get();
        return view('pembayaran.index', compact('pembayaran'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan'])->get(); // Supaya bisa tampil kode_pesanan dan info pelanggan
        return view('pembayaran.create', compact('pesanan'));
    }

    // Menyimpan data pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,id',
            'metode' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'status' => 'required|in:Dibayar,Menunggu,Gagal',
            'keterangan' => 'nullable|string',
        ]);

        // Generate kode pembayaran otomatis
        $latest = Pembayaran::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $kode = 'BYR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Hitung total dari detail pesanan yang sesuai dengan pesanan_id
        $total = DetailPesanan::where('pesanan_id', $request->pesanan_id)->sum('subtotal');

        Pembayaran::create([
            'kode_pembayaran' => $kode,
            'pesanan_id' => $request->pesanan_id,
            'total' => $total,
            'metode' => $request->metode,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil disimpan.');
    }

    public function show($id)
{
    $pembayaran = Pembayaran::with('pesanan')->findOrFail($id);
    return view('pembayaran.show', compact('pembayaran'));
}

public function edit($id)
{
    $pembayaran = Pembayaran::findOrFail($id);
    $pesanan = Pesanan::with('pelanggan')->get(); // Supaya bisa pilih ulang
    return view('pembayaran.edit', compact('pembayaran', 'pesanan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanan,id',
        'metode' => 'required|string|max:50',
        'tanggal' => 'required|date',
        'status' => 'required|in:Dibayar,Menunggu,Gagal',
        'keterangan' => 'nullable|string',
    ]);

    $pembayaran = Pembayaran::findOrFail($id);
    $total = \App\Models\DetailPesanan::where('pesanan_id', $request->pesanan_id)->sum('subtotal');

    $pembayaran->update([
        'pesanan_id' => $request->pesanan_id,
        'total' => $total,
        'metode' => $request->metode,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui.');
}

public function destroy($id)
{
    $pembayaran = Pembayaran::findOrFail($id);
    $pembayaran->delete();

    return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
}
}
