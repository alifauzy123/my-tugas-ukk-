<?php

namespace App\Http\Controllers;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;


class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::orderBy('id')->get();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $latest = KategoriProduk::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $kode = 'KTGPRD' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        KategoriProduk::create([
            'kode_kategori' => $kode,
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update($request->only(['nama_kategori', 'deskripsi', 'status']));

        return redirect()->route('kategori.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Data berhasil dihapus.');
    }
}

