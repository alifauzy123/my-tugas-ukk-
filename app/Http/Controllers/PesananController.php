<?php

// app/Http/Controllers/PesananController.php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Kasir;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        
        $pesanan = Pesanan::with(['pelanggan', 'kasir'])->orderBy('id')->get();
        return view('pesanan.index', compact('pesanan'));
    }

    public function create()
    {
        $latest = Pesanan::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $kode = 'PSN' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $pelanggan = \App\Models\Pelanggan::all();
        $kasir = \App\Models\Kasir::all();

        return view('pesanan.create', compact('kode', 'pelanggan', 'kasir'));
    }
    
    public function store(Request $request)
{
    //  dd($request->all());
    $request->validate([
        'pelanggan_id' => 'required|exists:pelanggan,id',
        'kasir_id' => 'required|exists:kasirs,id',
        'tanggal' => 'required|date',
        'status' => 'required|in:Pending,Diproses,Selesai',
        'catatan' => 'nullable|string',
    ]);

    // Generate kode otomatis
    $latest = Pesanan::latest('id')->first();
    $nextId = $latest ? $latest->id + 1 : 1;
    $kodePesanan = 'PSN' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    Pesanan::create([
        'kode_pesanan' => $kodePesanan,
        'pelanggan_id' => $request->pelanggan_id,
        'kasir_id' => $request->kasir_id,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
        'catatan' => $request->catatan,
    ]);

    return redirect()->route('pesanan.index')->with('success', 'Data pesanan berhasil disimpan.');
}

public function show($id)
{
    $pesanan = Pesanan::with(['pelanggan', 'kasir'])->findOrFail($id);
    return view('pesanan.show', compact('pesanan'));
}

public function edit($id)
{
    $pesanan = Pesanan::findOrFail($id);
    $pelanggan = \App\Models\Pelanggan::all();
    $kasir = \App\Models\Kasir::all();
    return view('pesanan.edit', compact('pesanan', 'pelanggan', 'kasir'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'pelanggan_id' => 'required|exists:pelanggan,id',
        'kasir_id' => 'required|exists:kasirs,id',
        'tanggal' => 'required|date',
        'status' => 'required|in:Pending,Diproses,Selesai',
        'catatan' => 'nullable|string',
    ]);

    $pesanan = Pesanan::findOrFail($id);
    $pesanan->update([
        'pelanggan_id' => $request->pelanggan_id,
        'kasir_id' => $request->kasir_id,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
        'catatan' => $request->catatan,
    ]);

    return redirect()->route('pesanan.index')->with('success', 'Data pesanan berhasil diperbarui.');
}
public function destroy($id)
{
    $pesanan = \App\Models\Pesanan::findOrFail($id);

    // Hapus semua detail pesanan terkait terlebih dahulu
    $pesanan->detailPesanan()->delete();

    // Hapus pesanan utama
    $pesanan->delete();

    return redirect()->route('pesanan.index')->with('success', 'Pesanan dan detailnya berhasil dihapus.');
}


}
