<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::orderBy('id', 'DESC')->paginate(10);
        return view('kendaraan.index', compact('kendaraan'));
    }

   public function create()
{
    return view('kendaraan.create');
}

public function show($id)
{
    $kendaraan = Kendaraan::findOrFail($id);
    return view('kendaraan.show', compact('kendaraan'));
}

  public function store(Request $request)
{
    $request->validate([
        'nama_kendaraan' => 'required',
        'nomer_polisi'   => 'required|unique:kendaraan,nomer_polisi',
    ]);

    // Generate
    $last = Kendaraan::orderBy('id', 'desc')->first();
    $kodeBaru = $last
        ? 'KND' . str_pad((int) substr($last->kode_kendaraan, 3) + 1, 3, '0', STR_PAD_LEFT)
        : 'KND001';

    Kendaraan::create([
        'kode_kendaraan' => $kodeBaru,
        'nama_kendaraan' => $request->nama_kendaraan,
        'nomer_polisi'   => $request->nomer_polisi,
        'supir'          => $request->supir,
        'status'         => $request->status,
        'catatan'        => $request->catatan,
    ]);

    return redirect()->route('kendaraan.index')
                     ->with('success', 'Data kendaraan berhasil ditambahkan.');
}



    public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $request->validate([
            'nama_kendaraan' => 'required',
            'nomer_polisi'   => "required|unique:kendaraan,nomer_polisi,$id",
        ]);

        $kendaraan->update([
            'nama_kendaraan' => $request->nama_kendaraan,
            'nomer_polisi'   => $request->nomer_polisi,
            'supir'          => $request->supir,
            'status'         => $request->status,
            'catatan'        => $request->catatan,
        ]);

        return redirect()->route('kendaraan.index')
                         ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kendaraan::findOrFail($id)->delete();

        return redirect()->route('kendaraan.index')
                         ->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
