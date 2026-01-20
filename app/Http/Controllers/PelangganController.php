<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('id')->get();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $last = Pelanggan::latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;
        $kode = 'PLG' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        Pelanggan::create([
            'kode_pelanggan' => $kode,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        $request->validate([
            'kode_pelanggan' => 'required|string|max:50',
            'nama_pelanggan' => 'required|string|max:100',
            'email' => 'required|email',
            'no_telp' => 'required|string',
            'status' => 'required|in:Aktif,Nonaktif',
            'alamat' => 'nullable|string',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'status' => $request->status,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // ✅ Tambahan: Fungsi DELETE
    public function destroy($id)
{

    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->delete();

    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
}

}
