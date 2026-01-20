<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ulasan = \App\Models\Ulasan::with('produk', 'pelanggan')->orderBy('id')->get();
        return view('ulasan.index', compact('ulasan'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $produk = \App\Models\Produk::all();
    $pelanggan = \App\Models\Pelanggan::all();
    return view('ulasan.create', compact('produk', 'pelanggan'));
}

public function store(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:produk,id',
        'pelanggan_id' => 'required|exists:pelanggan,id',
        'rating' => 'required|integer|min:1|max:10',
        'komentar' => 'nullable|string',
        'tanggal' => 'required|date',
        'status' => 'required|in:Aktif,Nonaktif',
    ]);

    $latest = \App\Models\Ulasan::latest('id')->first();
    $nextId = $latest ? $latest->id + 1 : 1;
    $kode = 'ULS' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    \App\Models\Ulasan::create([
        'kode_ulasan' => $kode,
        'produk_id' => $request->produk_id,
        'pelanggan_id' => $request->pelanggan_id,
        'rating' => $request->rating,
        'komentar' => $request->komentar,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
    ]);

    return redirect()->route('ulasan.index')->with('success', 'Data ulasan berhasil disimpan.');
}


    public function edit($id)
{
    $ulasan = Ulasan::findOrFail($id);
    $produk = Produk::orderBy('nama_produk')->get();
    $pelanggan = Pelanggan::orderBy('nama_pelanggan')->get();
    return view('ulasan.edit', compact('ulasan', 'produk', 'pelanggan'));
}   

public function update(Request $request, $id)
{
    $request->validate([
        'produk_id' => 'required|exists:produk,id',
        'pelanggan_id' => 'required|exists:pelanggan,id',
        'rating' => 'required|integer|min:1|max:10',
        'komentar' => 'nullable|string',
        'tanggal' => 'required|date',
        'status' => 'required|in:Aktif,Nonaktif',
    ]);

    $ulasan = Ulasan::findOrFail($id);
    $ulasan->update($request->all());

    return redirect()->route('ulasan.index')->with('success', 'Data ulasan berhasil diupdate.');
}

public function show($id)
{
    $ulasan = Ulasan::with(['produk', 'pelanggan'])->findOrFail($id);
    return view('ulasan.show', compact('ulasan'));
}

public function destroy($id)
{
    $ulasan = Ulasan::findOrFail($id);
    $ulasan->delete();
    return redirect()->route('ulasan.index')->with('success', 'Data ulasan berhasil dihapus.');
}

}
